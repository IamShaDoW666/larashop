<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Order;
use App\Models\Restorant;
use App\Services\ConfChanger;
use Razorpay\Api\Api;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {
        $restorant = $config->restorant;
        $data = [
            'razorpay_enable' => $request->razorpay_enable,
            'stripe_enable' => $request->stripe_enable,
        ];
        $restorant->setMultipleConfig($data);
        $config->razorpay_api_key = $request->razorpay_api_key;
        $config->razorpay_api_secret = $request->razorpay_api_secret;
        $config->stripe_api_key = $request->stripe_api_key;
        $config->stripe_api_secret = $request->stripe_api_secret;
        $config->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function payWithRazorpay(Request $request)
    {
        $restorant = Restorant::findOrFail($request->restorant);
        //dd($restorant->config->razorpay_api_key, $restorant->config->razorpay_api_secret);

        ConfChanger::switchCurrency($restorant);
        $values = [
            'receipt' => 'Payment',
            'amount' => $request->amount * 100,
            'currency' => config('global.currency')
        ];
        $api = new Api($restorant->config->razorpay_api_key, $restorant->config->razorpay_api_secret);
        $order = $api->order->create($values);
        return response($order->id);
    }

    public function payWithStripeLinks(Request $request)
    {        
        $amount = $request->amount * 100;
        $restorant = Restorant::findOrFail($request->restorant);
        ConfChanger::switchCurrency($restorant);

        Stripe::setApiKey($restorant->config->stripe_api_secret);

        $session = Session::create([
            // 'payment_method_types' => $paymentMethods,
            'line_items' => [[
                'price_data' => [
                    'currency' => config('global.currency'),
                    'product_data' => [
                        'name' => 'Payment' . " #" . '13243',
                    ],
                    'unit_amount' => (int)$amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('orders.store', ['restorant' => $request->restorant, 'form' => $request->form, 'cart' => $request->cart]),
            'cancel_url' => route('terms'),
        ]);
        // dd($session);     
        return $session->url;
    }

    public function stripeSuccess($order)
    {
    }
}
