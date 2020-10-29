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
    <script src="{{ route("duna.mobile.idbKeyval", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.axios", $mobile) }}"></script>
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
