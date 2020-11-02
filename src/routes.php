<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

// Admin view to check all service workers installed
Route::get('/duna/sw/config', function (Request $request) {
    return view("duna::sw.config");
})->name("duna.sw.config");

Route::namespace("Kineticamobile\Duna\Controllers")
    ->prefix('duna/{mobile}') //  Url
    ->as('duna.mobile.') // Name of routes
    ->middleware(['web','auth:sanctum'])
    ->group(function () {

        Route::get('/', 'ResourceController@index')->name("index");
        Route::post('/register', 'ResourceController@register')->name("register");

        Route::get('dashboard', 'ResourceController@dashboard')->name("dashboard");
        Route::get('icon.svg', 'ResourceController@icon')->name("icon");
        Route::get('sql.js', 'ResourceController@sql' )->name("sql");
        Route::get('manifest.json', 'ResourceController@manifest')->name("manifest");
        Route::get('sw-register-helpers.js', 'ResourceController@swRegisterHelpers')->name("sw-register-helpers");
        Route::get('sw-configuration.js', 'ResourceController@swConfiguration')->name("sw-configuration");
        Route::get('sw.js', 'ResourceController@sw')->name("sw");
        Route::get('basic.js', 'ResourceController@basic')->name("basic");
        Route::get('idb-keyval.js', 'ResourceController@idbKeyval')->name("idbKeyval");
        Route::get('axios.js', 'ResourceController@axios')->name("axios");
        Route::get('bg.jpg', 'ResourceController@bg')->name("bg");
        Route::get('alt-bg.jpg', 'ResourceController@altBg')->name("alt-bg");
        Route::get('profile-mobile.jpg', 'ResourceController@profileMobile')->name("profile-mobile");
        Route::get('profile-desktop.jpg', 'ResourceController@profileDesktop')->name("profile-desktop");
        Route::get('icon-mobile.png', 'ResourceController@iconMobile')->name("icon-mobile");
        Route::get('tailwind.css', 'ResourceController@tailwind')->name("tailwind");

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

});

Route::namespace("Kineticamobile\Duna\Controllers")
    ->prefix('duna/{mobile}/api') //  Url
    ->as('duna.mobile.') // Name of routes
    ->middleware(['auth:sanctum'])
    ->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/me', function (Request $request) {
            return $request->user();
        });

        Route::get('/check', function (Request $request) {
            return true;
        });

});
