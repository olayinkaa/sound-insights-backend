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

Route::post('login','AuthController@login')->name('login');
Route::post('register','AuthController@register')->name('register');

// Route::apiResource('mp3','Mp3Controller');
Route::get('mp3','Mp3Controller@index');
Route::post('mp3','Mp3Controller@store')->middleware('scope:create-mp3');
Route::get('mp3/{mp3}','Mp3Controller@show')->middleware('scope:update-mp3');
Route::put('mp3/{mp3}','Mp3Controller@update')->middleware('scope:update-mp3');
Route::delete('mp3/{mp3}','Mp3Controller@delete')->middleware('scope:delete-mp3');

Route::apiResource('dashboard','DashboardController',['only'=>['index']]);
Route::apiResource('contactus','ContactUsController');
Route::apiResource('aboutus','AboutUsController');
Route::get('mp3/download/{id}','Mp3Controller@downloadMp3')->name('download');
Route::name('verify')->get('user/verify/{token}','UserController@verify');
Route::name('resend')->get('user/{user}/resend','UserController@resend');
Route::name('send-email')->post('sendmail','EmailController@customerEmail');