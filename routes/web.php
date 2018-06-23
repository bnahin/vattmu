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

Route::group(['namespace' => 'Auth'], function () {
    $this->get('login', 'LoginController@showLoginForm')->name('login');
    $this->get('login/validate', 'LoginController@validateLogin')->name('validate');
    $this->post('login', 'LoginController@login');
    $this->post('logout', 'LoginController@logout')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', 'WelcomeController@index')->name('home');

    /** Weather */
    Route::get('/weather', 'WeatherController@index')->name('weather');
    Route::post('/weather/metar', 'WeatherController@metar');
});