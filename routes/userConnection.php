<?php

use App\Http\Controllers\Network\InteractionController;
/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "user" middleware group. Now create something great!
|
*/


Route::get('/sent_connection',[InteractionController::class, 'sentConnection']);
Route::get('/sent_request',[InteractionController::class, 'sentRequest']);
Route::get('/get_suggestion',[InteractionController::class,'getSuggestion']);
Route::get('/withdraw_connect',[InteractionController::class,'withDrawConnect']);
Route::get('/recieve_request',[InteractionController::class,'recieveRequest']);
Route::get('/accept_connect',[InteractionController::class,'acceptConnect']);
Route::get('/get_connection',[InteractionController::class,'getConnection']);
Route::get('/remove_connect',[InteractionController::class,'removeConnect']);