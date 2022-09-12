<?php

namespace App\Repositories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
class OrderRepository extends BaseOrderRepository
{

    private $orderMessage = ""; //The message we will send

    public function validateData()
    {
        $validator = Validator::make($this->request->all(), array_merge($this->expeditionRules(), $this->paymentRules()));
        if ($validator->fails()) {
            $this->status = false;
        }
        return $validator;
    }

    public function makeOrder()
    {

        //From Parent - Construct the order
        $this->constructOrder();

        // //From trait - set fee and time slot
        // $this->setAddressAndApplyDeliveryFee();
        // $this->setTimeSlot();

        // //From parent - check if order is ok - min price. -- Only for pickup - dine in should not have minimum
        // // $resultFromValidateOrder=$this->validateOrder();
        // // if($resultFromValidateOrder->fails()){return $resultFromValidateOrder;}

        //  //From trait - make attempt to pay order or get payment link
        $resultFromPayOrder = $this->payOrder();
        if ($resultFromPayOrder->fails()) {
            return $resultFromPayOrder;
        }

        // //Local - set Initial Status
        // $this->setInitialStatus();

        //  //Local - clear cart
        //  $this->clearCart();

        //  //Local - Notify
        $this->notify();

        // //At the end, return that all went ok
        return Validator::make([], []);
    }



    public function redirectOrInform()
    {
        if ($this->status) {
            if ($this->order->payment_link) {                
                return Inertia::location($this->order->payment_link);
            }                        
            $message = $this->order->getSocialMessageAttribute(true);
            $url = 'https://api.whatsapp.com/send?phone=' . $this->vendor->phone . '&text=' . $message;
            // dd($this->order->payment_link);
            //Set session token for customer viewing order status
            session(['order_token' => Crypt::encrypt($this->order->id)]);
            return Inertia::location($url);
        } else {
            //There was some error, return back to the order page
            return 'ERROR GO TO CART PAGE';
        }
    }

    private function clearCart()
    {
        Cart::clear();
    }

    private function notify()
    {
        $this->notifyOwner();
    }

    private function payOrder()
    {
        if ($this->request->payment_method === "cod") {
            return Validator::make([], []);
        } else if ($this->request->payment_method === "stripelinks") {
            return $this->payStripeLinksOrder();
        } else if ($this->request->payment_method === "razorpay") {
            return Validator::make([], []);
        }
    }

    public function payStripeLinksOrder()
    {
        if ($this->request->payment_method == 'stripe') {
            $this->request->payment_method = 'stripelinks';
        }
        $className = '\Modules\\' . ucfirst($this->request->payment_method) . '\Http\Controllers\App';
        $ref = new \ReflectionClass($className);
        $theValidator = $ref->newInstanceArgs(array($this->order, $this->vendor))->execute();        
        if ($theValidator->fails()) {
            $this->invalidateOrder();
        } else {
            //It is ok, use the link
            $this->paymentRedirect = $this->order->payment_link;        
            return $theValidator;
        }
        return $theValidator;
    }

    
}
