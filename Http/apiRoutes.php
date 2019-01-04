<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercecheckmo'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommercecheckmo.api.checkmo.index',
        'uses' => 'CheckmoApiController@index',
    ]);

    $router->get('/response', [
        'as' => 'icommercecheckmo.api.checkmo.response',
        'uses' => 'CheckmoApiController@response',
    ]);

});