setUpAxiosInstance();

async function setUpAxiosInstance()
{
    var token = await getApiToken()
    var test =  await axios.create({
        baseURL: '{{ route("duna.mobile.index", $mobile) }}',
        timeout: 1000,
        headers: {'Authorization': 'Bearer ' + token },
    });
    window.APP = test
}

function toBinArray(str) {
    var l = str.length,
        arr = new Uint8Array(l);
    for (var i = 0; i < l; i++) arr[i] = str.charCodeAt(i);
    return arr;
}

function toBinString(arr) {
    var uarr = new Uint8Array(arr);
    var strings = [], chunksize = 0xffff;
    // There is a maximum stack size. We cannot call String.fromCharCode with as many arguments as we want
    for (var i = 0; i * chunksize < uarr.length; i++) {
        strings.push(String.fromCharCode.apply(null, uarr.subarray(i * chunksize, (i + 1) * chunksize)));
    }
    return strings.join('');
}

var db

async function getDB()
{
    if(db){ return db }

    var dbstr = await idbKeyval.get("{{ $mobile }}.sqlite")

    if (dbstr) {
        db = new SQL.Database(toBinArray(dbstr));
    } else {
        db = new SQL.Database();
        db.run(`CREATE TABLE "avisos" (
            "id"	INTEGER,
            "method"	TEXT NOT NULL,
            "model"	TEXT NOT NULL,
            "data"	TEXT NOT NULL,
            "uploaded"	INTEGER NOT NULL DEFAULT 0,
            PRIMARY KEY("id" AUTOINCREMENT)
        );`);
    }
    return db
}

function login(event)
{
    event.preventDefault()

    axios.post(event.target.action, serializeForm(event.target))
        .then(loginSuccessfulReponse)
        .catch(error => console.log(error))

    return false;
}

var loginSuccessfulReponse = function(response)
{
    console.log(response)
    setApiToken(response.data)
    window.location.href = '{{ route('duna.mobile.dashboard', $mobile) }}';
}

function getApiToken()
{
    return idbKeyval.get("token_{{ $mobile }}")
}

function setApiToken(token)
{
    idbKeyval.set("token_{{ $mobile }}", token)
    return window.localStorage.getItem("token_{{ $mobile }}")
}

var serializeForm = function (form) {
    var obj = {};
    var formData = new FormData(form);
    for (var key of formData.keys()) {
        obj[key] = formData.get(key);
    }
    return obj;
};

var output = function(str)
{
    var output = document.getElementById("output");
    console.log(str)
    if(output) { output.innerHTML = JSON.stringify(str, null, 4) }
}

var getMe = function()
{
    console.log('/me')
    APP.get('/api/me')
        .then(response => output(response.data))
        .catch(output)
}

async function execAvisosSQL(sql, bindings)
{
    var db = await getDB()

    try {
        if(bindings){
            var contents = db.run(sql, bindings)
        }else{
            var contents = db.exec(sql);
        }
    } catch(err) {
        console.log(err)
        alert(err.message);
    }

    console.timeEnd("exec: " + sql);
    // Guardamos nuevo estado
    var dbstr = toBinString(db.export());
    //window.localStorage.setItem("avisos.sqlite", dbstr);
    idbKeyval.set("{{ $mobile }}.sqlite", dbstr)
    //delete dbstr
    // Devolvemos resultado de la consulta
    return contents
}

function insertAviso()
{
    return execAvisosSQL(`INSERT INTO avisos( method, model, data, uploaded)
                    VALUES    (?,     ?,             ?,                  ?)`,
                              ["GET", "Notification","{'key': 'value'}", 0]
    );
}
