@extends('duna::layouts.app')

@section('script')
<script> setupServiceWorker({}); </script>
@endsection

@section('content')
<!--Main Col-->
<div id="profile" class="w-full lg:w-3/5 rounded-lg lg:rounded-l-lg lg:rounded-r-none shadow-2xl bg-white opacity-75 mx-6 lg:mx-0">


    <div class="p-4 md:p-12 text-center lg:text-left">
        <!-- Image for mobile view-->
        <div class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center" style="background-image: url('{{ route('duna.mobile.profile-mobile', $mobile) }}')"></div>

        <h1 class="text-3xl font-bold pt-8 lg:pt-0">{{ Str::title($mobile) }} App</h1>
        <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-teal-500 opacity-25"></div>
        <p class="pt-8 text-sm">You can go offline and still see this content. API calls need connection & would not be cached</p>
        <br>

            <textarea class="bg-gray-700" id="output" rows="6" cols="50"></textarea>

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
@endsection
