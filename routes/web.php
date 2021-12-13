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

Route::view('/', 'frontend')->name('home');
Route::view('/profile/{id}', 'frontend')->name('profile');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['prefix' => 'data', 'as' => 'data'], function() {

    Route::get('user', [
        'uses' => 'App\Http\Controllers\UserController@index',
        'as' => 'index',
    ]);

    Route::post('login', [
        'uses' => 'App\Http\Controllers\Auth\LoginController@login',
        'as' => 'login',
    ]);

    Route::post('register', [
        'uses' => 'App\Http\Controllers\Auth\RegisterController@create',
        'as' => 'reg',
    ]);

    Route::get('getUsername/{id}', [
        'uses' => 'App\Http\Controllers\UserController@show',
        'as' => 'reg',
    ]);

});