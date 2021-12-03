<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/create', function() {
    return view('pages.create');  
});

Route::get('/load', function() {
    return view('pages.load');  
});
   

Route::get('/canvas', function () {
    return view('pages.canvas');
});

Route::resource('pages','App\Http\Controllers\PagesController');
// Route::resource('worlds', 'App\Http\Controllers\WorldsController');