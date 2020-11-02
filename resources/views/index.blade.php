@extends('duna::layouts.app')

@section('content')
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
@endsection
