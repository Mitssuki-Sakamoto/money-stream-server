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
Route::group(['middleware' =>['api']],function(){
    Route::post('user', 'UsersController@store');
});


Route::group(['middleware' =>['auth:api']],function(){
    Route::resource('user', 'UsersController', ['only' => ['show', 'update', 'destroy']]);
    Route::get('user/friends', 'UsersController@friends');
    Route::resource('event', 'EventController', ['only' => ['store']]);

});
