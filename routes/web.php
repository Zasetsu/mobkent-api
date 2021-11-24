<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('il-getir', 'HelperController@cities');
    $router->post('ilce-getir', 'HelperController@towns');
    $router->get('kategoriler', 'CategoriesController@all');
    $router->get('kategoriler', 'CategoriesController@all');
    $router->post('register/producer', 'ProducerController@register');

    $router->post('product/add', 'ProductController@create');
    $router->post('register/store', 'FirmController@register');
    $router->post('login', 'AccountController@login');
    $router->post('account/profile', 'AccountController@profile');
        $router->get('account/all-producers', 'AccountController@allProducers');

        $router->post('account/other-profile', 'AccountController@otherProfile');

        $router->post('product/user-products', 'ProductController@userProducts');

        $router->get('product/all-products', 'ProductController@allProducts');
                $router->post('product/detail', 'ProductController@details');


});


$router->get('/', function () use ($router) {
    return $router->app->version();
});
