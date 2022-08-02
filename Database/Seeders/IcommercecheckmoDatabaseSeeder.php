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
    public function run($methodsFromOther=null)
    {
        Model::unguard();

        $methods = config('asgard.icommercecheckmo.config.methods');

        //Only the methods that match with the config
        if(!is_null($methodsFromOther))
            $methods = array_intersect_key($methods,$methodsFromOther);

        if(count($methods)>0){

            $init = "Modules\Icommercecheckmo\Http\Controllers\Api\IcommerceCheckmoApiController";

            foreach ($methods as $key => $method) {

                $result = PaymentMethod::where('name',$method['name'])->first();

                if(!$result){

                    $options['init'] = $init;

                    $options['mainimage'] = null;
                    $options['minimunAmount'] = 0;

                    $titleTrans = $method['title'];
                    $descriptionTrans = $method['description'];

                    foreach (['en', 'es'] as $locale) {

                        if($locale=='en'){
                            $params = array(
                                'title' => trans($titleTrans),
                                'description' => trans($descriptionTrans),
                                'name' => $method['name'],
                                'status' => $method['status'],
                                'options' => $options
                            );

                            if(isset($method['parent_name']))
                                $params['parent_name'] = $method['parent_name'];

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
                     $this->command->alert("This method: {$method['name']} has already been installed !!");
                }
            }
        }else{
           $this->command->alert("No methods in the Config File !!"); 
        }
 
    }
}
