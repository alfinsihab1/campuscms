<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes (by FaturCMS)
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Namespace Prefix
$namespacePrefix = '\\'.config('faturcms.controllers.namespace').'\\';

// Slider
Route::get('/slider', $namespacePrefix.'SliderController@json')->name('api.slider.index');
