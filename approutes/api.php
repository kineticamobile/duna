<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/me', function (Request $request) {
    return $request->user();
});

Route::get('/check', function (Request $request) {
    return true;
});
