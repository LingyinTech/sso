<?php

use Illuminate\Support\Facades\Route;

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
Route::any('/wechat', 'WechatController@serve');

Route::get('/', ['middleware' => 'sso-login', 'uses' => 'IndexController@index'])->name('login');

Route::middleware('should-login')->group(function () {
    Route::post('/developer/create', 'DeveloperController@store');

    Route::post('/developer/{id:[\d]+}', 'DeveloperController@update');

    Route::get('/developer', 'DeveloperController@index');
});

