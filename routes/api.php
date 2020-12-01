<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/user','Api\LoginController@store')->name('login');
Route::post('/register','Api\RegisterController@store');

Route::group(['prefix' => '/chat'], function () {
    Route::get('/','Api\ChatController@index');
    Route::post('/','Api\ChatController@store');
});

Route::group(['prefix' => 'question'], function () {
    Route::get('/','Api\QuestionController@index');
});
Route::group(['prefix' => 'answer'], function () {
    Route::get('/','Api\AnswerController@index');
});
