<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorldsController;

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

Route::get('/load', [WorldsController::class, 'showAllWorlds']);
   

Route::get('/canvas/{id}',[WorldsController::class, 'show']);

Route::resource('pages','App\Http\Controllers\PagesController');
// Route::resource('worlds', 'App\Http\Controllers\WorldsController');

Route::post('/create', [WorldsController::class, 'store']);