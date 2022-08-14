<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Order;
use App\Models\Restorant;
use App\Services\ConfChanger;
use Razorpay\Api\Api;

use Illuminate\Http\Request;

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
        $config->razorpay_api_key = $request->razorpay_api_key;
        $config->razorpay_api_secret = $request->razorpay_api_secret;
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
        // dd($restorant->config->razorpay_api_key, $restorant->config->razorpay_api_secret);
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
}
