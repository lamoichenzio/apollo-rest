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
    'prefix' => 'users'
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
    'prefix' => 'files'
], function () {
    Route::get('/{image}', 'ImageFileController@show')->name('image.show');
});

//SURVEY
Route::group([
    'middleware' => 'api',
    'prefix' => 'surveys'
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
    'middleware' => ['api', 'qg.in.survey'],
    'prefix' => 'surveys/{survey}/question_groups'
], function () {
    Route::get('/', 'QuestionGroupController@index');
    Route::get('{questionGroup}', 'QuestionGroupController@show')->name('questionGroup.show');
    Route::post('/', 'QuestionGroupController@store');
    Route::put('/{questionGroup}', 'QuestionGroupController@update');
    Route::delete('/{questionGroup}', 'QuestionGroupController@destroy');
    Route::get('/{questionGroup}/questions', 'QuestionGroupController@listQuestions');
});

//INPUT QUESTION
Route::group([
    'middleware' => ['api', 'qg.in.survey'],
    'prefix' => 'surveys/{survey}/question_groups/{question_group}/input_questions'
], function () {
    Route::get('/{question}', 'InputQuestionController@show')->name('inputQuestion.show')
        ->middleware('inputquestion.in.qg');
    Route::post('/', 'InputQuestionController@create')->name('inputQuestion.create');
    Route::put('/{question}', 'InputQuestionController@update')->name('inputQuestion.update')
        ->middleware('inputquestion.in.qg');
    Route::delete('/{question}', 'InputQuestionController@delete')->name('inputQuestion.delete')
        ->middleware('inputquestion.in.qg');
});

//MULTI QUESTION
Route::group([
    'middleware' => ['api', 'qg.in.survey'],
    'prefix' => 'surveys/{survey}/question_groups/{question_group}/multi_questions'
], function () {
    Route::get('/{multiQuestion}', 'MultiQuestionController@show')
        ->name('multiQuestion.show')
        ->middleware('multiquestion.in.qg');
    Route::post('/', 'MultiQuestionController@store');
    Route::put('/{multiQuestion}', 'MultiQuestionController@update')
        ->middleware('multiquestion.in.qg');
    Route::delete('/{multiQuestion}', 'MultiQuestionController@destroy')
        ->middleware('multiquestion.in.qg');

    //OPTIONS
    Route::get('/{multiQuestion}/options', 'MultiQuestionController@listOptions')
        ->middleware('multiquestion.in.qg');
    Route::post('/{multiQuestion}/options', 'MultiQuestionController@storeOption')
        ->middleware('multiquestion.in.qg');
    Route::put('/{multiQuestion}/options/{option}', 'MultiQuestionController@updateOption')
        ->middleware('multiquestion.in.qg', "option.in.question");
    Route::delete('/{multiQuestion}/options/{option}', 'MultiQuestionController@destroyOption')
        ->middleware('multiquestion.in.qg', "option.in.question");
});
