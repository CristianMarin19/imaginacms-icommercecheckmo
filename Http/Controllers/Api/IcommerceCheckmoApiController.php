<?php

namespace Modules\Icommercecheckmo\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Repositories
use Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;

use Modules\User\Contracts\Authentication;
use Modules\User\Repositories\UserRepository;

use Modules\Icommerce\Events\OrderWasCreated;

class IcommerceCheckmoApiController extends BaseApiController
{

    private $checkmo;
    private $paymentMethod;
    private $order;
    private $orderController;
    private $transactionController;
    private $currency;
    private $user;
    protected $auth;

    public function __construct(
        IcommerceCheckmoRepository $checkmo,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        CurrencyRepository $currency,
        OrderApiController $orderController,
        TransactionApiController $transactionController,
        Authentication $auth, 
        UserRepository $user
    ){

        $this->checkmo = $checkmo;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->currency = $currency;
        $this->orderController = $orderController;
        $this->transactionController = $transactionController;
        $this->auth = $auth;
        $this->user = $user;
    }
    
    /**
     * Init data
     * @param Requests request
     * @param Requests orderid
     * @return route
     */
    public function init(Request $request){

        try {

            $orderID = $request->orderid;
            $paymentName = config('asgard.icommercecheckmo.config.paymentName');

            // Configuration
            $attribute = array('name' => $paymentName);
            $paymentMethod = $this->paymentMethod->findByAttributes($attribute);

            // Order
            $order = $this->order->find($orderID);

            // get currency active
            $currency = $this->currency->getActive();

            // Testing event (esto va es en order)
            event(new OrderWasCreated($order));
           
            $newstatusOrder = 12; // (For this module) "PROCESSED"

            // Create Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->create(new Request([
                    'order_id' => $order->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => $order->total,
                    'status' => $newstatusOrder
                ]))
            );
    
            // Update Order Process (For this module)
            $orderUP = $this->validateResponseApi(
                $this->orderController->update($order->id,new Request([
                    'order_id' => $order->id,
                    'status_id' => $newstatusOrder
                ]))
            );
           
            // Check order(For this module)
            if (!empty($order))
                $redirectRoute = route('icommerce.order.showorder', [$order->id, $order->key]);
            else
                $redirectRoute = route('homepage');


            // Response
            $response = [ 'data' => [
                "redirectRoute" => $redirectRoute
            ]];
            
            
          } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);

    }
    
    /**
     * Response Api Method
     * @param Requests request
     * @return route 
     */
    public function response(Request $request){

        /** 
         * Not applicable for this module
         * */ 
        
        // Check the response
        // Update Order Process (icommerce)
        // Check order

    }

}