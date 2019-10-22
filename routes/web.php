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

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('activation/{token}', 'Auth\LoginController@activate')->name('auth.activate');

// User Related Routes
Route::get('u/{user}', 'ProfileController@show');
Route::get('u/{user}/edit', 'UserController@edit');
Route::put('u/{user}/edit', 'UserController@update');
Route::put('u/{user}/password', 'UserController@password');

// Datasets Related Routes
Route::get('datasets', 'DatasetController@index');
Route::get('datasets/publish', 'DatasetController@create');
Route::post('datasets', 'DatasetController@store');
Route::get('d/{dataset}', 'DatasetController@show');
Route::get('d/{dataset}/edit', 'DatasetController@edit');
Route::put('d/{dataset}', 'DatasetController@update');
Route::post('d/{dataset}/file', 'DatasetFileController@upload');
Route::delete('d/{dataset}/{id}', 'DatasetFileController@delete');
Route::delete('d/{dataset}', 'DatasetController@destroy');
Route::get('d/{dataset}/publish', 'PublishDatasetController@toggle');
Route::get('d/{dataset}/feature', 'FeatureDatasetController@toggle');
Route::post('d/{dataset}/vote', 'VoteController@dataset');

// Code Related Routes
Route::get('codes', 'CodeController@index');
Route::get('c/{dataset}/publish', 'CodeController@create');
Route::post('codes', 'CodeController@store');
Route::get('c/{code}', 'CodeController@show');
Route::get('c/{code}/edit', 'CodeController@edit');
Route::put('c/{code}', 'CodeController@update');
Route::delete('c/{code}', 'CodeController@destroy');
Route::post('c/{code}/vote', 'VoteController@code');

// News Related Routes
Route::get('news', 'NewsController@index');
Route::post('news/{twitter_feed}/vote', 'VoteController@news');

// Forum Related Routes
Route::get('discuss', 'ThreadController@index');
Route::get('discuss/create', 'ThreadController@create');
Route::post('discuss', 'ThreadController@store');
Route::get('t/{category}/{thread}', 'ThreadController@show');
Route::get('t/{category}/{thread}/edit', 'ThreadController@edit');
Route::put('t/{category}/{thread}', 'ThreadController@update');
Route::delete('t/{category}/{thread}', 'ThreadController@destroy');
Route::get('t/{category}', 'ThreadController@index');
Route::post('t/{category}/{thread}/replies', 'ReplyController@store');
Route::post('replies/{reply}', 'ReplyController@bestAnswer');
Route::get('replies/{reply}/edit', 'ReplyController@edit');
Route::put('replies/{reply}', 'ReplyController@update');
Route::delete('replies/{reply}', 'ReplyController@destroy');

// Prediction Related Routes
Route::get('predict/heart', 'HeartDiseasePredictionController@form');
Route::post('predict/heart', 'HeartDiseasePredictionController@predict');
Route::get('predict/diabetes', 'DiabetesPredictionController@form');
Route::post('predict/diabetes', 'DiabetesPredictionController@predict');

if (env('APP_DEBUG')) {
    Route::get('l', function () {
        auth()->login(App\User::first());

        return redirect('/');
    });
}