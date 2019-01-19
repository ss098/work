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

Route::get('/', 'IndexController@index');
Route::get('/detail', 'IndexController@detail');
Route::post('/create', 'IndexController@create');

Route::group(['prefix' => 'recycle'], function ()
{
    Route::post('/', 'RecycleController@recycle');
    Route::get('overview', 'RecycleController@overview');
    Route::get('attachment', 'RecycleController@attachment');
    Route::get('export', 'RecycleController@export');
});
