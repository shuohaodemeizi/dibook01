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

//GET xxx.xxx.com/api/xx
Route::group(['namespace' => 'Api'], function () {

    //展示分类为1的信息流，钉死1
    Route::get('/index', 'IndexController@index');

    //根据分类ID展示信息流，根据是否启用
    Route::get('/c/{category_id}', 'IndexController@category')->where('category_id', '\d+');

    //根据pid展示文章详情，根据是否启用
    Route::get('/p/{product_id}', 'IndexController@product')->where('product_id', '\d+');

    //根据tag_id展示信息流，根据是否启用
    Route::get('/t/{tag_id}', 'IndexController@tag')->where('tag_id', '\d+');

    Route::get('/search/{keywords}', 'IndexController@search')->where('keywords', '\d+');


});


