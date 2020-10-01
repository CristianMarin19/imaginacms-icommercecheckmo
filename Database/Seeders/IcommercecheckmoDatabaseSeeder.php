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

        $name = config('asgard.icommercecheckmo.config.paymentName');
        $result = PaymentMethod::where('name',$name)->first();

        if(!$result){
            $options['init'] = "Modules\Icommercecheckmo\Http\Controllers\Api\IcommerceCheckmoApiController";
            $options['mainimage'] = null;
            $options['minimunAmount'] = 0;

            $titleTrans = 'icommercecheckmo::icommercecheckmos.single';
            $descriptionTrans = 'icommercecheckmo::icommercecheckmos.description';

            foreach (['en', 'es'] as $locale) {

                if($locale=='en'){
                    $params = array(
                        'title' => trans($titleTrans),
                        'description' => trans($descriptionTrans),
                        'name' => config('asgard.icommercecheckmo.config.paymentName'),
                        'status' => 1,
                        'options' => $options
                    );

                    $paymentMethod = PaymentMethod::create($params);
                    
                }else{

                    $title = trans($titleTrans,[],$locale);
                    $description = trans($descriptionTrans,[],$locale);

                    $paymentMethod->translateOrNew($locale)->title = $title;
                    $paymentMethod->translateOrNew($locale)->description = $description;

                    $paymentMethod->save();
                }

            }// Foreach

        }else{
            $this->command->alert("This method has already been installed !!");
        }
 
    }
}
