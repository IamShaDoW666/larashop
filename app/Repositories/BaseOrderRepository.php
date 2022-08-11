<?php

namespace App\Repositories;


use App\Models\Order;
use App\Models\Product;
use App\Models\Restorant as Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\NewOrder as PusherNewOrder;
use App\Http\Resources\OrderResource;
use App\Models\Variant;
use Nwidart\Modules\Facades\Module;

class BaseOrderRepository extends Controller
{

    /**
     * @var Request request - The request made
     */

    public $request;

    public $vendor;

    public $order;

    public $status = true;

    public $isNewOrder = true;

    public $errorMessage = "";

    public $paymentRedirect = null;

    public $isMobileOrder = false;

    public $orderType = null;

    public $redirectLink;

    public function __construct($vendor_id, $request)
    {
        $this->request = $request;

        $this->orderType = $request->order_method;
        // $this->hasPayment=$hasPayment;
        // $this->isStripe=$isStripe;

        //Set the Vendor
        $this->vendor = Vendor::findOrFail($vendor_id);
    }



    public function constructOrder()
    {
        // Create the order 
        $this->createOrder();

        // Set Items
        $this->setItems();

        //Set Comment
        // $this->setComment();

        //Calculate fees
        // $this->calculateFees();

    }

    // public function validateOrder(){
    //     $minValue = 0;
    //     if ($this->request->delivery_mov) {
    //         if ($this->vendor->minimum > $this->request->delivery_mov) {
    //             $minValue = $this->vendor->minimum;
    //         } else {
    //             $minValue = $this->request->delivery_mov;
    //         }
    //     }
    //     $validator = Validator::make(['order_price'=>$this->order->order_price], [
    //         'order_price'=>['numeric','min:'.$minValue]
    //     ]);
    //     if($validator->fails()){
    //         $this->invalidateOrder();
    //     }
    //     return $validator;
    // }

    public function invalidateOrder()
    {
        $this->status = false;
        $this->order->delete();
    }

    public function updateOrder()
    {
        //Store it if not stored yet, otherwise update it
        $this->order->update();
    }

    private function createOrder()
    {
        if ($this->order == null) {
            $this->order = new Order;
            $this->order->restorant_id = $this->vendor->id;
            $this->order->order_type = $this->orderType;
            $this->order->customer_name = $this->request->customer_name;
            $this->order->customer_phone = $this->request->phone;
            $this->order->address = $this->request->address;
            $this->order->delivery_fee = money($this->request->delivery_fee, config('global.currency', true))->getAmount();

            //Client
            // if(auth()->user()){
            //     $this->order->client_id=auth()->user()->id;
            // }

            $this->order->total = 0;
            $this->order->tax = 0;
            $this->order->tax_name = $this->vendor->config->tax_name;
            $this->order->tax_percent = $this->vendor->config->tax;

            //Save order
            $this->order->save();

            $this->order->uuid = md5($this->order->id);
            $this->order->update();
        } else {
            //Order is already initialized - in case of continues ordering
            $this->isNewOrder = false;
        }
    }

    private function setItems()
    {

        foreach ($this->request->items as $key => $item) {

            //Obtain the item
            $theItem = Product::findOrFail($item['id']);

            //List of extras
            $extras = [];

            //The price of the item or variant
            $itemSelectedPrice = $theItem->price;

            //Find the variant
            $variantName = '';
            if ($item['variantId']) {
                //Find the variant
                $variant = Variant::findOrFail($item['variantId']);
                $itemSelectedPrice = $variant->price;
                $variantName = $variant->name;
            }

            //    //Find the extras
            //     foreach ($item['extrasSelected'] as $key => $extra) {
            //         $theExtra = $theItem->extras()->findOrFail($extra['id']);
            //         $itemSelectedPrice+=$theExtra->price;
            //         array_push($extras, $theExtra->name.' + '.money($theExtra->price, config('settings.cashier_currency'), config('settings.do_convertion')));
            //     }

            //Total vat on this item
            // $totalCalculatedVAT = $item['quantity'] * ($theItem->vat > 0?$itemSelectedPrice * ($theItem->vat / 100):0);

            $this->order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'variant_price' => $itemSelectedPrice,
                'variant_id' => $variant->id ?? null,
                'variant_name' => $variant->name ?? null,
            ]);
        }


        // //After we have updated the list of items, we need to update the order price
        $order_price = 0;
        // $total_order_vat = 0;
        foreach ($this->order->products()->get() as $key => $item) {
            $order_price += $item->pivot->quantity * $item->pivot->variant_price;
            // $total_order_vat += $item->pivot->vatvalue;
        }

        $this->order->subtotal = $order_price;


        //calculate tax if module available
        if (Module::has('TaxConfig')) {
            if ($this->order->tax && $this->order->tax != 0) {
                $orderTaxValue = (int)round(($order_price * $this->vendor->config->tax) / 100);
                $this->order->tax = $orderTaxValue;
                $order_price +=  $orderTaxValue;
            }
        }

        if ($this->order->delivery_fee) {
            $order_price += $this->order->delivery_fee;
        }
        $this->order->total = $order_price;
        // $this->order->vatvalue = $total_order_vat;

        // //Set coupons
        // if ($this->request->has('coupon_code') && strlen($this->request->coupon_code) > 0) {
        //     $coupon = Coupons::where(['code' => $this->request->coupon_code])->where('restaurant_id', $this->vendor->id)->get()->first();
        //     if ($coupon) {
        //         $deduct = $coupon->calculateDeduct($this->order->order_price);
        //         if ($deduct) {
        //             $coupon->decrement('limit_to_num_uses');
        //             $coupon->increment('used_count');
        //             $this->order->coupon = $this->request->coupon_code;
        //             if ($deduct > $this->order->order_price) {
        //                 $this->order->discount = $order_price;

        //                 //In this case, order should be considered as paid one
        //                 //$this->order->payment_status = 'paid';
        //             } else {
        //                 $this->order->discount = $deduct;
        //             }
        //         }
        //     }
        // }


        //Update the order with the item
        $this->order->update();
    }

    // private function setComment(){

    //     $comment = $this->request->comment ? strip_tags($this->request->comment.'') : '';
    //     $this->order->comment = $this->order->comment.' '.$comment;
    //     $this->order->update();
    // }

    // private function calculateFees(){
    //     $this->order->static_fee=$this->vendor->static_fee;
    //     $this->order->fee=$this->vendor->fee;
    //     $this->order->fee_value=($this->vendor->fee/100)*($this->order->order_price_with_discount-$this->vendor->static_fee);
    //     $this->order->update();
    // }

    // public function notifyAdmin(){
    //     //Does nothing
    // }

    public function notifyOwner()
    {
        //Inform owner - via email, sms or db
        // $this->vendor->user->notify((new OrderNotification($this->order))->locale(strtolower(config('settings.app_locale'))));

        // Broadcast Pusher if exists        
        if (config('pusher') && config('pusher.exists')) {
            broadcast(new PusherNewOrder(new OrderResource($this->order)));
        }

        //Dispatch Approved by admin event
        // OrderAcceptedByAdmin::dispatch($this->order);
    }
}
