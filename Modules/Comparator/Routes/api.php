<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;


$router->group(['prefix' => '/comparator'], function (Router $router) {

    $router->post('find', [
        'as' => 'api.comparator.find',
        'uses' => 'ComparatorController@find',
    ]);

});