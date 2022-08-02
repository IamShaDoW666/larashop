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
        //  $resultFromPayOrder=$this->payOrder();
        //  if($resultFromPayOrder->fails()){return $resultFromPayOrder;}

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
            // if ($this->order->payment_link) {
            //     return Redirect::to($this->order->payment_link);
            // }            
            
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
}
