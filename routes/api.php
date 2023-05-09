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



