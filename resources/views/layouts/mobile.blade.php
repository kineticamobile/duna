<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$mobile}} - Login</title>
	<meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/idb-keyval@3/dist/idb-keyval-iife.min.js"></script>
    <script src="{{ route("duna.mobile.basic", $mobile) }}"></script>
    <style>
        .body-bg {
            background-color: #9921e8;
            background-image: linear-gradient(315deg, #9921e8 0%, #5f72be 74%);
        }
    </style>
</head>
<body class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <h1>Welcome to {{ $mobile }}
        <form id="login" method="POST" action="{{ route("duna.mobile.register", $mobile) }}" onsubmit="login(event)">
            <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                email
            </label>
            <input id="email" name="email" type="text" placeholder="email" value="admin@admin.com" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" >
            </div>
            <div class="mb-6">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input id="password" name="password" type="password" placeholder="******************" class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" >
            </div>
            <div class="mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="device_name">
                    Device Name
                </label>
                <input id="device_name" name="device_name" type="text" placeholder="Device Name" class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="device_name" type="text" placeholder="Device Name">
                <p class="text-red text-xs italic">Cuando dejes de usar el dispositivo podrás quitar permisos en la aplicación</p>
            </div>
            <div class="flex items-center justify-between">
            <button  type="submit">
                Sign In
            </button>
            </div>
        </form>
    </div>
</body>
</html>
