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
    return view('welcome');
});

Route::get('/auth/bintan-sso/login', [App\Http\Controllers\Auth\BintanSSOController::class, 'login']);
Route::get('/auth/bintan-sso/callback', [App\Http\Controllers\Auth\BintanSSOController::class, 'callbackFromSSO']);