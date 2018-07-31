<?php

use Illuminate\Routing\Router;

    $router->group(['prefix'=>'icommercecheckmo'],function (Router $router){
        $locale = LaravelLocalization::setLocale() ?: App::getLocale();

        $router->get('/', [
            'as' => 'icommercecheckmo',
            'uses' => 'PublicController@index',
        ]);
        
    });