<?php

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

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');
Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');

Route::group(
    [
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Admin',
        'middleware' => ['auth'],
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::post('/users/{user}/verify', 'UsersController@verify')->name('users.verify');
        Route::resource('users', 'UsersController');

    }
);