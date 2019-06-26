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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('survey', 'SurveyController')->only(['create', 'store']);

    Route::resource('profile', 'ProfileController', ['parameters' => [
        'profile' => 'user'
    ]])->only(['edit', 'update'])->middleware('can.edit');

    Route::resource('questions', 'QuestionController')->except('show');
});
