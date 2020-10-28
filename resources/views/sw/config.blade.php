<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Service Workers Installed</title>
    <meta name="description" content="Home App">
</head>

<body>
    <header>
      <h1>Service Workers Installed</h1>
      <h2>Service Worker Action</h2>

      Status: <span id="status">?</span><br/>

      Network: <span id="online">?</span>
      <p id="action"></p>

      <h2>Service Workers Registered</h2>
      <ul id="registered">
      </ul>

      <h2>Service Worker Configuration</h2>
      <table>
        <tr>
            <th>Key</th>
            <th>Default (sw.js)</th>
            <th>Custom (sw-configuration.js)</th>
        </tr>
        <tbody  id="configurations">

        </tbody>
      </table>
    </header>
    <main>


    </main>


    <script>

        var loc = window.location.href;
        var currentFolder = window.location.href.substring(0, loc.lastIndexOf('/')) + "/";

        async function getServiceWorkers() {
            return navigator.serviceWorker.getRegistrations().then((SWs) => SWs);
        }

        function setupConfigurationPage() {
            getServiceWorkers().then(sws => {
                var swsScopes = sws.map(sw => sw.scope)
                // Check Status of current folder
                var status = swsScopes.includes(currentFolder) ? "Active" : "Inactive"
                document.getElementById("status").innerHTML = status + " - " + currentFolder
                // Add button Register/Unregister
                var buttonnode= document.createElement('input');
                buttonnode.setAttribute('type','button');
                document.getElementById("action").innerHTML = ''
                document.getElementById("action").appendChild(buttonnode);

                if(status == "Inactive"){
                    buttonnode.setAttribute('value','Register');
                    buttonnode.addEventListener('click', () => {
                        setupServiceWorker(setupConfigurationPage)
                    });
                }

                if(status == "Active"){
                    buttonnode.setAttribute('value','Unregister');
                    buttonnode.addEventListener('click', () => {
                        unregisterServiceWorker(setupConfigurationPage)
                    });
                }

                var online = window.navigator.onLine;
                document.getElementById("online").innerHTML = online ? "Online" : "Offline"


                // List all services workers of server
                var ul = document.getElementById("registered")
                ul.innerHTML = "";
                swsScopes = swsScopes.sort()
                swsScopes.forEach(scope => {
                    var li = document.createElement("li");
                    li.appendChild(document.createTextNode(scope));
                    ul.appendChild(li)
                });
            })


        }

        setupConfigurationPage()

    </script>
</body>
</html>
