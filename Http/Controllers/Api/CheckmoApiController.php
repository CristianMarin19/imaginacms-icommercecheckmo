<?php

namespace Modules\Icommercecheckmo\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
//use Modules\Icommercecheckmo\Transformers\CheckmoTransformer;

// Repositories
use Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository;

//use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;

// Entities
use Modules\Icommerce\Entities\PaymentMethod;

class CheckmoApiController extends BaseApiController
{

    private $checkmo;
    private $paymentMethod;

    public function _construct(IcommerceCheckmoRepository $checkmo){
        $this->checkmo = $checkmo;
        $this->paymentMethod = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
    }
    
    /**
     * Init data
     * @param Requests request
     * @return redirect payment 
     */
    public function index(Request $request){

        try {

            /** 
             *  1. ID de la orden (sesion)
             *  2. Cargar la data del metodo
             *  3. Return (Ruta externa, ruta interna, vista del modulo)
             * 
            */

            $param = 1;
            //$config = $this->paymentMethod->find($param);
            //$config = PaymentMethod::find($param);
            
            //dd($config);

            $response = ['data' => "respuesta"];
            //Request to Repository
            //$cartProducts = $this->cartProduct->getItemsBy($this->getParamsRequest());
      
            //Response
            //$response = ['data' => CartProductTransformer::collection($cartProducts)];
            //If request pagination add meta-page
           // $request->page ? $response['meta'] = ['page' => $this->pageTransformer($cartProducts)] : false;
      
          } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);

        /*
        if ($request->session()->exists('orderID')) {

            try{

                $email_from = $this->setting->get('icommerce::from-email');
                $email_to = explode(',',$this->setting->get('icommerce::form-emails'));
                $sender  = $this->setting->get('core::site-name');
              
                $orderID = session('orderID');
                $order = $this->order->find($orderID);

                $products=[];
                foreach ($order->products as $product) {
                    array_push($products,[
                        "title" => $product->title,
                        "sku" => $product->sku,
                        "quantity" => $product->pivot->quantity,
                        "price" => $product->pivot->price,
                        "total" => $product->pivot->total,
                    ]);
                }

                $success_process = icommerce_executePostOrder($orderID,1,$request);

                $userEmail = $order->email;
                $userFirstname = "{$order->first_name} {$order->last_name}";

                $content=[
                    'order'=> $order,
                    'products' => $products,
                    'user' => $userFirstname
                ];

                $msjTheme = "icommerce::email.success_order";
                $msjSubject = trans('icommerce::common.emailSubject.complete').$order->id;
                $msjIntro = trans('icommerce::common.emailIntro.complete');

                
                $mailUser= icommerce_emailSend(['email_from'=>[$email_from],'theme' => $msjTheme,'email_to' => $userEmail,'subject' => $msjSubject, 'sender'=>$sender,'data' => array('title' => $msjSubject,'intro'=> $msjIntro,'content'=>$content)]);

                $mailAdmin = icommerce_emailSend(['email_from'=>[$email_from],'theme' => $msjTheme,'email_to' => $email_to,'subject' => $msjSubject, 'sender'=>$sender,'data' => array('title' => $msjSubject,'intro'=> $msjIntro,'content'=>$content)]);
                


            }catch (\PPConnectionException $ex) {
              \Log::info($e->getMessage());
              return redirect()->route('homepage')
                ->withError(trans('icommerce::common.order_error'));

            }


        }
  
        $user = $this->auth->user();
        if (isset($user) && !empty($user))
          if (!empty($order))
            return redirect()->route('icommerce.orders.show', [$order->id]);
          else
            return redirect()->route('homepage')
              ->withSuccess(trans('icommerce::common.order_success'));
        else
          if (!empty($order))
            return redirect()->route('icommerce.order.showorder', [$order->id, $order->key]);
          else
            return redirect()->route('homepage')
              ->withSuccess(trans('icommerce::common.order_success'));

        */


    }
    
    /**
     * Response Api Method
     * @param Requests request
     * @return redirect payment 
     */
    public function response(Request $request){

        /**
         * 1. Verificar la respuesta
         * 2. Configuracion - Actualizar el estatus de la orden (icommerce)
         * 3. Configuracion - Envio de Email (icommerce)
         * 4. Reedireccionar - Homepage o al ordershows
         */
        
    

    }


    public function ko(Request $request){

    }

     /**
     * Button Back PayU
     * @param  Request $request
     * @return redirect
     */
    public function back(){

    }

     /**
     * Send Information
     * @param Requests request
     * @return redirect
     */
    public function send(){

    }


}