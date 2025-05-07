<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

Route::get('/test-session', function () {
    session(['test' => 'working']);
    return response()->json([
        'session_test' => session('test'),
        'session_id' => session()->getId()
    ]);
});
