<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>{{ $mobile }} Service Worker</title>
    <meta name="description" content="Home App">
    <link rel="icon" type="image/svg+xml" sizes="512x512" href="icon.svg">
    <link rel="apple-touch-icon" href="icon.svg">
    <link rel="apple-touch-startup-image" href="icon.svg">
    <link rel="manifest" href="manifest.json">
    <script src="configure_sw.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/idb-keyval@3/dist/idb-keyval-iife.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ==" crossorigin="anonymous"></script>
    <script src="{{ route("duna.mobile.sql", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.basic", $mobile) }}"></script>
</head>

<body>
    <header>
      <h1>{{ Str::title($mobile)}} Dashboard</h1>
    </header>
    <main>


    </main>


    <script>
        setupServiceWorker({});

    </script>
</body>
</html>
