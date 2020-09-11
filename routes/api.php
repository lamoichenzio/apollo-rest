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
    Route::get('{question_group}', 'QuestionGroupController@show')->name('questionGroup.show');
    Route::post('/', 'QuestionGroupController@store');
    Route::put('/{question_group}', 'QuestionGroupController@update');
    Route::delete('/{question_group}', 'QuestionGroupController@destroy');
    Route::get('/{question_group}/questions', 'QuestionGroupController@listQuestions');
});

//INPUT QUESTIONS
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

//MULTI QUESTIONS
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

//MATRIX QUESTIONS
Route::group([
    'middleware' => ['api', 'qg.in.survey', 'matrixquestion.in.qg'],
    'prefix' => '/surveys/{survey}/question_groups/{question_group}/matrix_questions'
], function () {
    Route::get('/{matrixQuestion}', 'MatrixQuestionController@show')
        ->name('matrixQuestion.show');
    Route::post('/', 'MatrixQuestionController@store');
    Route::put('/{matrixQuestion}', 'MatrixQuestionController@update');
    Route::delete('/{matrixQuestion}', 'MatrixQuestionController@destroy');
});

//MATRIX QUESTION ELEMENTS
Route::group([
    'prefix' => 'surveys/{survey}/question_groups/{question_group}/matrix_questions/{matrixQuestion}/elements',
    'middleware' => ['api', 'qg.in.survey', 'matrixquestion.in.qg', 'element.in.matrix']
], function () {
    Route::get('/', 'MatrixQuestionElementController@index');
    Route::post('/', 'MatrixQuestionElementController@store')->middleware('can:create,App\MatrixQuestionElement');
    Route::put('/{element}', 'MatrixQuestionElementController@update')->middleware('can:update,element');
    Route::delete('/{element}', 'MatrixQuestionElementController@destroy')->middleware('can:delete,element');
});

//MATRIX QUESTION OPTIONS
Route::group([
    'prefix' => 'surveys/{survey}/question_groups/{question_group}/matrix_questions/{matrixQuestion}/options',
    'middleware' => ['api', 'qg.in.survey', 'matrixquestion.in.qg', 'element.in.matrix']
], function () {
    Route::get('/', 'MatrixQuestionOptionController@index');
    Route::post('/', 'MatrixQuestionOptionController@store')->middleware('can:create,App\QuestionOption');
    Route::put('/{option}', 'MatrixQuestionOptionController@update')->middleware('can:update,option');
    Route::delete('/{option}', 'MatrixQuestionOptionController@destroy')->middleware('can:delete,option');
});
