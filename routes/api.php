<?php

use Illuminate\Http\Request;
use Ajifatur\FaturCMS\Models\Package;

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

// Update Package
Route::post('/package/update', $namespacePrefix.'PackageController@updateMe');