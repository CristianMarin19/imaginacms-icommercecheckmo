<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercecheckmo'], function (Router $router) {
    
    $router->get('/{orderid}', [
        'as' => 'icommercecheckmo.api.checkmo.init',
        'uses' => 'IcommerceCheckmoApiController@init',
    ]);

    $router->get('/response', [
        'as' => 'icommercecheckmo.api.checkmo.response',
        'uses' => 'IcommerceCheckmoApiController@response',
    ]);

});