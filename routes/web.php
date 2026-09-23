<?php

use Illuminate\Support\Facades\Route;

// 1. & 5. Ad�m: Base URL (/) -> Temporary Main Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Ad�m: Sabit hello rotas�
Route::get('/hello', function () {
    return 'Hello, world!';
});

// 3. Ad�m: Dinamik isim parametreli hello rotas�
Route::get('/hello/{name}', function ($name) {
    return 'Hello, ' . ucfirst($name) . '!';
});

// 4. Ad�m: �ki say�y� toplayan dinamik sum rotas�
Route::get('/sum/{number1}/{number2}', function ($number1, $number2) {
    return (string) ($number1 + $number2);
});

// 6. Ad�m: Temporary About Page
Route::get('/about', function () {
    return view('about');
});