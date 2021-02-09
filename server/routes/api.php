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
    Route::post('user', 'UsersController@store')->name('user.store');
});


Route::group(['middleware' =>['auth:api']],function(){
    Route::resource('user', 'UsersController', ['only' => ['show', 'update', 'destroy']]);
    Route::get('user/friends', 'UsersController@friends');
    Route::resource('event', 'EventController', ['only' => ['store', 'update', 'destroy']]);
    Route::get('event/list', 'EventController@list')->name('event.list');
    Route::get('event/users/{event_id}', 'EventController@users')->name('event.users');
    Route::post('event/user_invent/{event_id}', 'EventController@user_invent')->name('event.user_invent');
    Route::post('event/accept_invent/{event_id}', 'EventController@accept_invent')->name('event.accept_invent');
    Route::delete('event/delete_user/{event_id}/{user_id}', 'EventController@delete_user')->name('event.delete_user');

});
