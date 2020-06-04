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
Route::any('/wechat', 'WeChatController@serve');

Route::get('/', ['middleware' => 'sso-login', 'uses' => 'IndexController@index']);

Route::get('/developer', 'DeveloperController@index');
