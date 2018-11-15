<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('/table_data', 'TableDataController');//含：index,create,store,show,edit,update,destroy //https://laravel.com/docs/5.0/controllers#implicit-controllers
    $router->resource('/table_data_date', 'TableDataDateController');
    $router->resource('/table_data_dateitem', 'TableDataDateitemController');
    $router->resource('/products', 'ProductsController');
    $router->resource('/product_categorys', 'ProductCategorysController');
    $router->resource('/product_tags', 'ProductTagsController');

    $router->resource('/topics', 'TopicsController');


});
