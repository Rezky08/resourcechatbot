<?php

use Illuminate\Routing\RouteGroup;
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

Route::get('/', 'HomeController@index');
Route::group(['prefix' => 'chat'], function () {
    Route::get('/','ChatController@index');
});
Route::group(['prefix' => 'user'], function () {
    Route::get('/','UserController@index');
});
Route::group(['prefix' => 'label'], function () {
    Route::get('/','LabelController@index');
    Route::post('/add','LabelController@store');
    Route::put('/edit/{id}','LabelController@update');
    Route::delete('/delete/{id}','LabelController@destroy');
});
Route::group(['prefix' => 'question'], function () {
    Route::get('/','QuestionController@index');
    Route::get('/add', 'QuestionController@create');
    Route::post('/add', 'QuestionController@store');
    Route::get('/edit/{id}', 'QuestionController@edit');
    Route::put('/edit/{id}', 'QuestionController@update');
    Route::delete('/delete/{id}','QuestionController@destroy');
    Route::post('/import','QuestionController@importExcel');
});
Route::group(['prefix' => 'answer'], function () {
    Route::get('/','AnswerController@index');
    Route::get('/add', 'AnswerController@create');
    Route::post('/add', 'AnswerController@store');
    Route::get('/edit/{id}', 'AnswerController@edit');
    Route::put('/edit/{id}', 'AnswerController@update');
    Route::delete('/delete/{id}','AnswerController@destroy');
    Route::post('/import','AnswerController@importExcel');
});
Route::group(['prefix' => 'chatbot'], function () {
    Route::get('/','TrainChatbotController@index');
    Route::post('/','TrainChatbotController@store');
});
