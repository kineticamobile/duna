<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>{{ Str::title($mobile) }} App</title>
    <meta name="description" content="{{ Str::title($mobile) }} App">
    <link rel="icon" type="image/png" sizes="512x512" href="icon-mobile.png">
    <link rel="apple-touch-icon" href="icon-mobile.png">
    <link rel="apple-touch-startup-image" href="icon-mobile.png">
    <link rel="manifest" crossorigin="use-credentials" href="{{ route("duna.mobile.manifest", $mobile) }}"/>

    <link rel="stylesheet" href="{{ route("duna.mobile.tailwind", $mobile) }}">
    <script src="{{ route("duna.mobile.sw-register-helpers", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.idbKeyval", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.axios", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.sql", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.basic", $mobile) }}"></script>
</head>

<body class="font-sans antialiased text-gray-900 leading-normal tracking-wider bg-cover" style="background-image:url('https://source.unsplash.com/a2kD4b0KK4s');">



    <div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">

        @yield('content')

        <!-- Pin to top right corner -->
        <div class="absolute top-0 right-0 h-12 w-18 p-4">
            <button class="js-change-theme focus:outline-none">🌙</button>
        </div>

    </div>

    @yield('script')

    <script>
        //Toggle mode
        const toggle = document.querySelector('.js-change-theme');
        const body = document.querySelector('body');
        const profile = document.getElementById('profile');


        toggle.addEventListener('click', () => {
            if (body.classList.contains('text-gray-900')) {
                toggle.innerHTML = "☀️";
                body.classList.remove('text-gray-900');
                body.classList.add('text-gray-100');
                body.style = "background-image:url('https://source.unsplash.com/PP8Escz15d8');"
                profile.classList.remove('bg-white');
                profile.classList.add('bg-gray-900');
            } else {
                toggle.innerHTML = "🌙";
                body.classList.remove('text-gray-100');
                body.classList.add('text-gray-900');
                body.style = "background-image:url('https://source.unsplash.com/a2kD4b0KK4s');"
                profile.classList.remove('bg-gray-900');
                profile.classList.add('bg-white');
            }
        });

    </script>


</body>
</html>

