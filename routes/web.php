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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('survey', 'SurveyController')->except(['index']);

    Route::resource('profile', 'ProfileController', ['parameters' => [
        'profile' => 'user'
    ]])->only(['edit', 'update'])->middleware('can.edit');
});
