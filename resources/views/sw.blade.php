const CACHE_NAME = '{{ $mobile }}-configure-sw';

function isServiceWorkerContext()
{
    return self.constructor.name === "ServiceWorkerGlobalScope"
}

if( isServiceWorkerContext() ) {
    self.importScripts('sw-configuration.js');
    self.importScripts('idb-keyval.js');
}

async function getApiToken()
{
    return await idbKeyval.get("token_{{ $mobile }}")
}

const swDefault = {
    "MAX_WAIT": 100,
    "skipWaiting" : false, // Install and replace current Service Worker(testing purposes)
    "verbose" : 0, // Show all log messages
    "cacheOnInstall" : [
        "icon.svg",
    ],
    "offlineFirstPages" : [
    ],
    "cacheableStatus" :[ 200 ],
    "levels" : {
        "ALL" : 0,
        "DEBUG" : 10,
        "INFO" : 20,
        "WARNING" : 30,
        "ERROR" : 50
    },
    "isOfflineFirst": (url) => sw.offlineFirstPages.includes(url),
    "log": (...args) => {
        var firstParam = args.shift()

        if(sw.levels[firstParam] >= sw.verbose) {
            console.info(`[SW-${firstParam}]`, ...args)
            //console.log(new Error().stack)
        }
    },
    "cache" : async (cache, url, response) => {

        if(typeof url === "object"){
            url = url.url.replace(self.registration.scope, "")
        }

        if(!sw.cacheableStatus.includes(response.status) && !url.startsWith('api')){
            sw.log(`INFO`, `NOT CACHED : '🔴' HTTP ${response.status} / ${url}`)
        } else if(url.startsWith('api')) {
            sw.log(`INFO`, `NOT CACHED : '🔴' API Call / ${url}`)
        } else {
            await cache.put(url, response);
            sw.log(`INFO`, `CACHED     : '💚' HTTP ${response.status} / ${url}`)
            sw.log(`INFO`, url)
        }
    },
    /*
      https://developer.mozilla.org/en-US/docs/Web/API/Service_Worker_API

      Installation is attempted when
        * the downloaded file is found to be new — either different to an existing service worker (byte-wise compared),
        * Or the first service worker encountered for this page/site.
     */
    "install" : (event) => {
        //sw.log("INFO", "Start Installation...")
        //console.groupCollapsed(`SW Installation`)
        sw.log("INFO", "Start Installation...")
        if(sw.skipWaiting){
            sw.log("INFO", "self.skipWaiting() on install called")
            self.skipWaiting()
        }
        event.waitUntil(
            //sw.log("INFO", `Deleting Cache ${CACHE_NAME}`)
            caches.delete(CACHE_NAME)
                .then(() => caches.open(CACHE_NAME))
                .then(async cache => {
                    sw.log("INFO", `Before Cache sw.cacheOnInstall ${sw.cacheOnInstall.length} items`, sw.cacheOnInstall)
                    const leadingSlashRemoved = sw.cacheOnInstall //.map(url => url);
                    do {
                        const sliceDice = leadingSlashRemoved.splice(0, 10);
                        await sw.waitForAll(sliceDice.map(async url => {
                            await sw.cache(cache, url, await fetch(url, { headers: { Authorization: 'Bearer ' + getApiToken() } }))
                        }));
                    } while(leadingSlashRemoved.length > 0);
                    sw.log("INFO", "End Installation.")
                    //console.groupEnd()
                    return true;
            })
        );

    },
    "waitForAll" : async (promises) => {
        return new Promise( resolve => {
            let rc = { success: 0, failure:0 };
            for (let i=0; i < promises.length; i++) {
                promises[i]
                .then(()=>{
                    rc.success++;
                    if (rc.success+rc.failure === promises.length) resolve(rc);
                }).catch(err => {
                    rc.failure++;
                    if (rc.success+rc.failure === promises.length) resolve(rc);
                    console.error(`error occurred ${err}`);
                });
            }
        });
    },
    "defaultFetch" : async (event) => {
        const relativeUrl = event.request.url.replace(this.registration.scope, '')
        sw.log("DEBUG", `defaultFetch url`, relativeUrl)
        const cachedResponsePromise = caches.match(event.request);
        const token = getApiToken()
        console.log("token", token)
        const fetchPromise = fetch(event.request,{ headers: { Authorization: 'Bearer ' + await getApiToken() } });
        const timeoutPromise = sw.timeoutPromise();
        finalResponse = Promise.race([fetchPromise, timeoutPromise]).then(async res => {
            sw.log("DEBUG", `race`, res)
            // Fetch successful, probably online. See if we also have the cached response:
            const cachedResponse = await cachedResponsePromise.catch(err => null);
            if (res === "timedout" || !res.ok) {
                sw.log("DEBUG", `res === "timedout" or !res.ok`, res)
                // Fetch didn't throw but the result wasn't ok either.
                // Could be timeout, a 404, 500 or maybe offline?
                // In case we have an OK response in the cache, respond with that one instead:
                if (cachedResponse && cachedResponse.ok) {
                    sw.log("DEBUG", `cachedResponse && cachedResponse.ok`)
                    if (res === "timedout") sw.log("INFO", event.request.url, "timedout. Serving it from cache to speed up site");
                    //console.groupEnd()
                    sw.log("WARNING", `cachedResponse`)
                    return cachedResponse;
                } else if (res === "timedout") {
                    sw.log("DEBUG", `We don't have anything in cache. Wait for fetch even if it takes time.`)
                    //console.groupEnd()
                    res = await fetchPromise;
                } else {
                    //console.groupEnd()
                    sw.log("WARNING", `onlineResponse`)
                    return res;
                }
            }

            if (res.ok) {
                sw.log("DEBUG", `res ok`, res)
                // Should we update the cache with this fresh version?
                if (!cachedResponse || (cachedResponse.headers.get("last-modified") !== res.headers.get("last-modified"))) {
                    // There were no cached response, or "last-modified" headers was changed - keep the cache up-to-date,
                    // so that, when the user goes offline, it will have the latest and greatest, and not revert to old versions
                    //await cache.put(event.request, res.clone());

                    await sw.cache(
                        await caches.open(CACHE_NAME),
                        event.request,
                        res.clone()
                    )
                }
            }
            //console.groupEnd()
            sw.log("WARNING", `onlineResponse`)
            return res;
        }, async error => {
            //sw.log("WARNING", `error`, error)
            console.dir(error)
            const cachedResponse = await cachedResponsePromise.catch(err => null);
            if (cachedResponse && cachedResponse.ok) {
                sw.log("INFO", `From Cache ${event.request.url} - ${relativeUrl}`)
                sw.log("WARNING", `cachedResponse`)
                //console.groupEnd()
                return cachedResponse;
            }
            throw error;
        });
        sw.log("DEBUG", `defaultFetch finalResponse`, finalResponse)
        return finalResponse;
    },
    "offlineFetch": async (event) => {
        const relativeUrl = event.request.url.replace(this.registration.scope, '')
        sw.log("DEBUG", `offlineFetch url`, relativeUrl)
        let finalResponse;
        const cachedResponsePromise = caches.match(event.request);
        const cachedResponse = await cachedResponsePromise.catch(err => null);
        if (cachedResponse && cachedResponse.ok) {
            finalResponse = cachedResponse;
            sw.log("DEBUG", `OfflineFirst Cached Response`, finalResponse)
            sw.log("WARNING", `cachedResponse`)
        }else{
            const fetchPromise = fetch(event.request);
            finalResponse = await fetchPromise;
            sw.log("DEBUG", `OfflineFirst Online Response`, finalResponse)
            sw.log("WARNING", `onlineResponse`)
        }
        return finalResponse
    },
    "selectFetch": async (event) => {
        const relativeUrl = event.request.url.replace(this.registration.scope, '')
        if(sw.isOfflineFirst(relativeUrl)){
            sw.log("WARNING", `OfflineFetch`)
            return await sw.offlineFetch(event)
        }else{
            sw.log("WARNING", `DefaultFetch`)
            return await sw.defaultFetch(event)
        }
    },
    "fetch" : (event) => {
        // https://www.freecodecamp.org/news/javascript-es6-promises-for-beginners-resolve-reject-and-chaining-explained/
        event.respondWith(new Promise(resolve => {
            resolve(sw.selectFetch(event))
        }))
    },
    "timeoutPromise" : () => {
        return new Promise(resolve => {
            setTimeout(()=>resolve("timedout"), sw.MAX_WAIT);
        })
    },
    "setup" : () => {
        self.addEventListener('install', sw.install);
        self.addEventListener('fetch', sw.fetch);
    }
};

//console.log(self instanceof ServiceWorkerGlobalScope)

const sw = {...swDefault, ...swCustom }

//console.log(sw);

if( isServiceWorkerContext() ) {
    console.warn("Service Worker Register Context")
    console.warn(self.registration.scope)
    sw.setup()
}


