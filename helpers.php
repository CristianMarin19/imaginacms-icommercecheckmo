<?php

use Modules\Icommercecheckmo\Entities\Checkmoconfig;

if (! function_exists('icommercecheckmo_get_configuration')) {

    function icommercecheckmo_get_configuration()
    {

    	$configuration = new Checkmoconfig();
    	return $configuration->getData();

    }

}

if (! function_exists('icommercecheckmo_get_entity')) {

	function icommercecheckmo_get_entity()
    {
    	$entity = new Checkmoconfig;
    	return $entity;	
    }

}
