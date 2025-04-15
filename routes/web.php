<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/Fitness', function () {
    return view('Fitness');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/membership', function () {
    return view('membership');
});