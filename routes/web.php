<?php

use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Login route
Route::get('/login', function () {
    return view('welcome');
})->name('login');

// Dashboard route
Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

// Catch all other routes and return the welcome view
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
