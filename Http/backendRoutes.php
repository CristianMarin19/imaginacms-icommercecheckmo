<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommercecheckmo'], function (Router $router) {
    $router->bind('checkmoconfig', function ($id) {
        return app('Modules\Icommercecheckmo\Repositories\CheckmoConfigRepository')->find($id);
    });
    $router->get('checkmoconfigs', [
        'as' => 'admin.icommercecheckmo.checkmoconfig.index',
        'uses' => 'CheckmoConfigController@index',
        'middleware' => 'can:icommercecheckmo.checkmoconfigs.index'
    ]);
    $router->get('checkmoconfigs/create', [
        'as' => 'admin.icommercecheckmo.checkmoconfig.create',
        'uses' => 'CheckmoConfigController@create',
        'middleware' => 'can:icommercecheckmo.checkmoconfigs.create'
    ]);
    $router->post('checkmoconfigs', [
        'as' => 'admin.icommercecheckmo.checkmoconfig.store',
        'uses' => 'CheckmoConfigController@store',
        'middleware' => 'can:icommercecheckmo.checkmoconfigs.create'
    ]);
    $router->get('checkmoconfigs/{checkmoconfig}/edit', [
        'as' => 'admin.icommercecheckmo.checkmoconfig.edit',
        'uses' => 'CheckmoConfigController@edit',
        'middleware' => 'can:icommercecheckmo.checkmoconfigs.edit'
    ]);
    $router->put('checkmoconfigs', [
        'as' => 'admin.icommercecheckmo.checkmoconfig.update',
        'uses' => 'CheckmoConfigController@update',
        'middleware' => 'can:icommercecheckmo.checkmoconfigs.edit'
    ]);
    $router->delete('checkmoconfigs/{checkmoconfig}', [
        'as' => 'admin.icommercecheckmo.checkmoconfig.destroy',
        'uses' => 'CheckmoConfigController@destroy',
        'middleware' => 'can:icommercecheckmo.checkmoconfigs.destroy'
    ]);
// append

});
