<?php

return [
    'name' => 'Icommercecheckmo',
    'paymentName' => 'icommercecheckmo',
    'methods' => [
    	// Contraentrega
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.checkmo.title',
    		'description' => 'icommerceagree::icommerceagrees.methods.checkmo.description',
            'name' => 'icommercecheckmo',
    		'status' => 1
    	],
    	// Efectivo
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.cash.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.cash.description',
            'name' => 'icommercecash',
    		'status' => 0
    	],
    	//Davidplata
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.davidplata.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.davidplata.description',
            'name' => 'icommercedavidplata',
    		'status' => 0
    	],
    	//nequi
    	[
    		'title' => 'icommercecheckmo::icommercecheckmos.methods.nequi.title',
    		'description' => 'icommercecheckmo::icommercecheckmos.methods.nequi.description',
            'name' => 'icommercenequi',
    		'status' => 0
    	],
    	
    ]
];
