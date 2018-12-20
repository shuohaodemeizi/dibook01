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

//Route::get('/', function () {
//    //return view('welcome');
//
//    return 'home';
//});

Route::get('/swagger/doc', 'SwaggerController@doc');

Route::group(['namespace' => 'Api'], function () {

    //展示分类为1的信息流，钉死1
    Route::get('', 'IndexController@indexView');
    Route::get('/s', 'IndexController@searchView');

    Route::get('/c/{category_id}.html', 'IndexController@categoryView')->where('category_id', '\d+');
    Route::get('/p/{product_id}.html', 'IndexController@productView')->where('product_id', '\d+');
    Route::get('/p/{product_id}', 'IndexController@productView')->where('product_id', '\d+');
    Route::get('/pcode', 'IndexController@pcode');
    Route::get('/t/{tag_id}.html', 'IndexController@tagView')->where('tag_id', '\d+');
    Route::get('/search/{keywords}.html', 'IndexController@searchView')->where('keywords', '\d+');

});

