<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//AUTH
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('logout', 'AuthController@logout')->name('auth.logout');
    Route::post('refresh', 'AuthController@refresh')->name('auth.refresh');
    Route::get('profile', 'AuthController@profile')->name('auth.profile');
});

//USER
Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function () {
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('{user}', 'UserController@show')->name('user.show');
    Route::post('/', 'UserController@store')->name('user.store');
    Route::put('/{user}', 'UserController@update')->name('user.update');
    Route::delete('/{user}', 'UserController@destroy')->name('user.destroy');
});

//IMAGE FILE
Route::group([
    'middleware' => 'api',
    'prefix' => 'file'
], function () {
    Route::get('/{image}', 'ImageFileController@show')->name('image.show');
});

//SURVEY
Route::group([
    'middleware' => 'api',
    'prefix' => 'survey'
], function () {
    Route::get('/', 'SurveyController@index')->name('survey.index');
    Route::get('{survey}', 'SurveyController@show')->name('survey.show');
    Route::post('/', 'SurveyController@store')->name('survey.store');
    Route::put('/{survey}', 'SurveyController@update')->name('survey.update');
    Route::delete('/{survey}', 'SurveyController@destroy')->name('survey.destroy');
    Route::post('/count', 'SurveyController@count')->name('survey.countAll');
});

//QUESTION GROUP
Route::group([
    'middleware' => 'api',
    'prefix' => 'questionGroup'
], function () {
    Route::get('/', 'QuestionGroupController@index')->name('questionGroup.index');
    Route::get('{questionGroup}', 'QuestionGroupController@show')->name('questionGroup.show');
    Route::post('/', 'QuestionGroupController@store')->name('questionGroup.store');
    Route::put('/{questionGroup}', 'QuestionGroupController@update')->name('questionGroup.update');
    Route::delete('/{questionGroup}', 'QuestionGroupController@destroy')->name('questionGroup.destroy');
});