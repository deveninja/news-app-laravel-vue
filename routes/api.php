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



/**
 * -------------------------------------------------------------------------
 * Routes for Articles
 * -------------------------------------------------------------------------
 */

/** List all Articles */
Route::get('articles', 'ArticleController@index');

/** Show single Article */
Route::get('article/{id}', 'ArticleController@show');

/** Create new Article */
Route::post('article', 'ArticleController@store');

/** Update Articles */
Route::put('article', 'ArticleController@store');

/** Delete Article */
Route::delete('article/{id}', 'ArticleController@destroy');