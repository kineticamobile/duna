<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    $appName = ':lc:appname';
    return view("duna::$appName.index");
})->name("index");

Route::post('/register', function(Request $request)
{
    $request->validate([ 'device_name' => 'required' ]);

    return $request->user()->createToken($request->device_name)->plainTextToken;
})->name("register");


Route::get('/', function(){
    $appName = ":lc:appname";
    return view("duna::index", ["mobile" => $appName]);
})->name("index");

Route::post('/register', function(Request $request)
{
    $request->validate([ 'device_name' => 'required' ]);

    return $request->user()->createToken($request->device_name)->plainTextToken;
})->name("register");

Route::get('dashboard', function(){
    $appName = ":lc:appname";
    return view("duna::dashboard", ["mobile" => $appName]);
})->name("dashboard");

Route::get('basic.js', function(){
    $appName = ":lc:appname";
    return view("duna::basic", ["mobile" => $appName]);
})->name("basic");

Route::get('manifest.json', function(){
    $appName = ":lc:appname";
    return view("duna::manifest", ["mobile" => $appName]);
})->name("manifest");

Route::get('sw-register-helpers.js', function(){
    $appName = ":lc:appname";
    return view("duna::sw-register-helpers", ["mobile" => $appName]);
})->name("sw-register-helpers");

Route::get('sw-configuration.js', function(){
    $appName = ":lc:appname";
    return response()
            ->view("duna::sw-configuration", ["mobile" => $appName])
            ->header('Content-Type', 'application/javascript');
})->name("sw-configuration");

Route::get('sw.js', function(){
    $appName = ":lc:appname";
    return response()
            ->view("duna::sw", ["mobile" => $appName])
            ->header('Content-Type', 'application/javascript');
})->name("sw");

// The next routes are static assets so you can find them in APP/public/duna/:lc:appname
Route::get('profile-mobile.jpg', function(){})->name("profile-mobile");
Route::get('profile-desktop.jpg', function(){})->name("profile-desktop");
Route::get('tailwind.css', function(){})->name("tailwind");
Route::get('idb-keyval.js', function(){})->name("idbKeyval");
Route::get('axios.js', function(){})->name("axios");
Route::get('sql.js', function(){} )->name("sql");
Route::get('bg.jpg', function(){})->name("bg");
Route::get('alt-bg.jpg', function(){})->name("alt-bg");

