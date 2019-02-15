<?php

namespace Modules\Icommercecheckmo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\PaymentMethod;

class IcommercecheckmoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $options['init'] = "Modules\Icommercecheckmo\Http\Controllers\Api\IcommerceCheckmoApiController";
        $options['mainimage'] = null;

        $params = array(
            'title' => trans('icommercecheckmo::icommercecheckmos.single'),
            'description' => trans('icommercecheckmo::icommercecheckmos.description'),
            'name' => config('asgard.icommercecheckmo.config.paymentName'),
            'status' => 0,
            'options' => $options
        );

        PaymentMethod::create($params);
       
    }
}
