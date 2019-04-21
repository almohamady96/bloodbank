<?php

use Illuminate\Http\Request;

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
Route::group(['prefix'=>'v1','namespace'=>'Api'],function () {
    Route::get('governorates', 'MainController@governorates');
    Route::get('cities', 'MainController@cities');
    Route::get('blood-types','MainController@blood_types');
    Route::get('categories','MainController@categories');
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('reset-password','AuthController@reset_password');
    Route::post('new-password','AuthController@new_password');


    Route::group(['middleware'=>'auth:api'],function (){
        Route::get('posts','MainController@posts');
        Route::post('profile','AuthController@profile');
        Route::post('register-token', 'AuthController@register_token');
        Route::post('remove-token', 'AuthController@remove_token');
        Route::post('notifications-settings','AuthController@notifications_settings');
        Route::get('post','MainController@post');
        Route::get('donation-requests','MainController@donations_requests');
        Route::get('donation-request','MainController@donation_request');
        Route::post('donation-request-create','MainController@donation_request_create');
        Route::post('post-favourite','MainController@post_favourite');
        Route::get('my-favourites', 'MainController@my_favourites');
        Route::get('notifications', 'MainController@notifications');
        Route::get('settings', 'MainController@settings');
        Route::post('contact','MainController@contact');
        Route::post('report','MainController@report');


    });

});

// api/v1/governorates
