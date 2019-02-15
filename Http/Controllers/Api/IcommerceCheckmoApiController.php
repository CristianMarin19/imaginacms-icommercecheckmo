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


class IcommerceCheckmoApiController extends BaseApiController
{

    private $checkmo;
    private $paymentMethod;
    private $order;
    private $orderController;
    private $transaction;
    private $transactionController;
    private $currency;
    
    public function __construct(
        IcommerceCheckmoRepository $checkmo,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        CurrencyRepository $currency
    ){

        $this->checkmo = $checkmo;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->currency = $currency;
        
    }
    
    /**
     * Init data
     * @param Requests request
     * @param Requests orderid
     * @return route
     */
    public function init(Request $request){

        try {

            $orderID = $request->orderID;
            \Log::info('Module Icommercecheckmo: Init-ID:'.$orderID);

            $paymentName = config('asgard.icommercecheckmo.config.paymentName');

            // Configuration
            $attribute = array('name' => $paymentName);
            $paymentMethod = $this->paymentMethod->findByAttributes($attribute);

            // Order
            $order = $this->order->find($orderID);

            // get currency active
            $currency = $this->currency->getActive();


            $newstatusOrder = 13; // (For this module) "PROCESSED"

            \Log::info('Module Icommercecheckmo: Response-ID:'.$orderID);

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
            
            // Nothing to reedirect
            $redirectRoute = "";

            // Response
            $response = [ 'data' => [
                "redirectRoute" => $redirectRoute,
                "external" => false
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