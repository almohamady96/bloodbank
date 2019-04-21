<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('governorate', 'GovernorateController');
Route::resource('city', 'CityController');
Route::resource('category','CategoryController');
Route::resource('post','PostController');
Route::resource('donation','DonationController');
Route::resource('contact','ContactController');
Route::resource('client','ClientController');
Route::resource('report','ReportController');
Route::resource('setting','SettingController');
//  user reset password
Route::get('user/change-password','UserController@changePassword');
Route::post('user/change-password','UserController@changePasswordSave');

