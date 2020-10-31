<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>{{ Str::title($mobile) }} Service Worker</title>
    <meta name="description" content="Home App">
    <link rel="icon" type="image/svg+xml" sizes="512x512" href="icon.svg">
    <link rel="apple-touch-icon" href="icon.svg">
    <link rel="apple-touch-startup-image" href="icon.svg">
    <link rel="manifest" href="manifest.json">

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss/dist/tailwind.min.css">
    <script src="configure_sw.js"></script>
    <script src="{{ route("duna.mobile.idbKeyval", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.axios", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.sql", $mobile) }}"></script>
    <script src="{{ route("duna.mobile.basic", $mobile) }}"></script>
</head>

<body class="font-sans antialiased text-gray-900 leading-normal tracking-wider bg-cover" style="background-image:url('https://source.unsplash.com/a2kD4b0KK4s');">



    <div class="max-w-2xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">

      <!--Main Col-->
      <div id="profile" class="w-full lg:w-6/6 rounded-lg lg:rounded-l-lg shadow-2xl bg-white opacity-75 mx-6 lg:mx-0">


          <div class="p-6 md:p-12 text-center lg:text-left">
              <!-- Image for mobile view-->
              <div class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center" style="background-image: url('https://source.unsplash.com/cYfnzLLmDlI')"></div>

              <h1 class="text-3xl font-bold pt-8 lg:pt-0">{{ Str::title($mobile) }} App</h1>
              <form id="login" method="POST" action="{{ route("duna.mobile.register", $mobile) }}" onsubmit="login(event)">
                    <div class="mb-6">
                        <label class="block text-grey-darker text-sm font-bold mb-2" for="device_name">
                            Device Name
                        </label>
                        <input id="device_name" name="device_name" type="text" placeholder="Device Name" class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" id="device_name" type="text" placeholder="Device Name">
                    </div>
                    <div class="flex items-center justify-between">
                    <button class="bg-teal-700 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded-full" type="submit">
                        Register Device
                    </button>
                    </div>
                </form>



              <!-- Use https://simpleicons.org/ to find the svg for your preferred product -->

          </div>

      </div>

      <!-- Pin to top right corner -->
        <div class="absolute top-0 right-0 h-12 w-18 p-4">
          <button class="js-change-theme focus:outline-none">🌙</button>
        </div>

  </div>

      <script src="https://unpkg.com/tippy.js@4"></script>
      <script>
          //Init tooltips
          tippy('.link',{
            placement: 'bottom'
          })

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
            } else
            {
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

