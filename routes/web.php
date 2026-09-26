<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', function () {
    return view('main');
})->name('beranda');

Route::get('/event', function () {
    return view('event');
})->name('event');

Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

Route::get('/testimoni', function () {
    return view('testimoni');
})->name('testimoni');