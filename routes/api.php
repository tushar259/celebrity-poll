<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/upload-images', 'App\Http\Controllers\PollController@uploadImages');
Route::post('/check-if-headline-used', 'App\Http\Controllers\PollController@checkIfHeadlineUsed');
Route::post('/upload-newly-added-poll', 'App\Http\Controllers\PollController@uploadNewlyAddedPoll');
Route::post('/get-poll-info', 'App\Http\Controllers\PollController@getPollInfo');
Route::get('/get-all-poll', 'App\Http\Controllers\PollController@getAllPoll');
Route::post('/get-all-poll-industry-wise', 'App\Http\Controllers\PollController@getAllPollIndustryWise');
Route::get('/get-poll-with-winning-list', 'App\Http\Controllers\PollController@getPollForWinningList');
Route::post('/upload-newly-winner-poll', 'App\Http\Controllers\PollController@uploadNewlyWinnerPoll');
// Route::get('/test-delete', 'App\Http\Controllers\PollController@testDelete');
Route::get('/get-result-list-poll', 'App\Http\Controllers\PollController@getResultListPoll');
Route::post('/get-result-list-poll-industry-wise', 'App\Http\Controllers\PollController@getResultListPollIndustryWise');
Route::post('/get-poll-winner-info', 'App\Http\Controllers\PollController@getPollWinnerInfo');
Route::post('/vote-selected-candidate', 'App\Http\Controllers\PollController@voteSelectedCandidate');

Route::post('/create-custom-account', 'App\Http\Controllers\UserController@createCustomAccount');
Route::post('/login-custom-user', 'App\Http\Controllers\UserController@loginCustomUser');


Route::group(['middleware'=>'api','prefix'=>'auth'], function($router){
	Route::post('/create-account', 'App\Http\Controllers\UserController@createAccount');
	Route::post('/login', 'App\Http\Controllers\UserController@loginAccount');
});



