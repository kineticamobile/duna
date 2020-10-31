<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>{{ Str::title($mobile) }} App</title>
    <meta name="description" content="Home App">
    <link rel="icon" type="image/png" sizes="512x512" href="icon-mobile.png">
    <link rel="apple-touch-icon" href="icon-mobile.png">
    <link rel="apple-touch-startup-image" href="icon-mobile.png">
    <link rel="manifest" crossorigin="use-credentials" href="manifest.json"/>


    <link rel="stylesheet" href="{{ route("duna.mobile.tailwind", $mobile) }}">

    <script src="configure_sw.js"></script>
    <script src="{{ route("duna.mobile.idbKeyval", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.axios", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.sql", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.basic", $mobile) }}"></script>
</head>

<body class="font-sans antialiased text-gray-900 leading-normal tracking-wider bg-cover" style="background-image:url('{{ route('duna.mobile.bg', $mobile) }}');">



    <div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">

      <!--Main Col-->
      <div id="profile" class="w-full lg:w-3/5 rounded-lg lg:rounded-l-lg lg:rounded-r-none shadow-2xl bg-white opacity-75 mx-6 lg:mx-0">


          <div class="p-4 md:p-12 text-center lg:text-left">
              <!-- Image for mobile view-->
              <div class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center" style="background-image: url('{{ route('duna.mobile.profile-mobile', $mobile) }}')"></div>

              <h1 class="text-3xl font-bold pt-8 lg:pt-0">{{ Str::title($mobile) }} App</h1>
              <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-teal-500 opacity-25"></div>
              <p class="pt-8 text-sm">You can go offline and still see this content. API calls need connection & would not be cached</p>
              <br>

                  <textarea class="bg-gray-500" id="output" rows="6" cols="50"></textarea>

              <div class="pt-12 pb-8">
                  <button onclick="getMe()" class="bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded-full">
                    Api /me
                  </button>

              </div>



              <!-- Use https://simpleicons.org/ to find the svg for your preferred product -->

          </div>

      </div>

      <!--Img Col-->
      <div class="w-full lg:w-2/5">
          <!-- Big profile image for side bar (desktop) -->
          <img src="{{ route('duna.mobile.profile-desktop', $mobile) }}" class="rounded-none lg:rounded-lg shadow-2xl hidden lg:block">
          <!-- Image from: http://unsplash.com/photos/MP0IUfwrn0A -->

      </div>


      <!-- Pin to top right corner -->
        <div class="absolute top-0 right-0 h-12 w-18 p-4">
          <button class="js-change-theme focus:outline-none">🌙</button>
        </div>

  </div>

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
              body.style = "background-image:url('{{ route('duna.mobile.alt-bg', $mobile) }}');"
              profile.classList.remove('bg-white');
              profile.classList.add('bg-gray-900');
            } else
            {
              toggle.innerHTML = "🌙";
              body.classList.remove('text-gray-100');
              body.classList.add('text-gray-900');
              body.style = "background-image:url('{{ route('duna.mobile.bg', $mobile) }}');"
              profile.classList.remove('bg-gray-900');
              profile.classList.add('bg-white');
            }
          });

      </script>



    <script>
        setupServiceWorker({});

    </script>
</body>
</html>
