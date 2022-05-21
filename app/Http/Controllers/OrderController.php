<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Http\Resources\AreaResource;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Product;
use App\Models\Order;
use App\Models\Restorant;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;

class OrderController extends Controller
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


    public function store(StoreOrderRequest $request)
    {
        // dd($request->validated());
        $cart = $request->cart;
        dd(config());
        $items_ids = Arr::pluck($cart['items'], 'id');
        $items_quantity = Arr::pluck($cart['items'], 'quantity');
        $items = Product::find($items_ids);
        $order = Order::factory()->create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'address' => $request->address,
            'order_type' => $request->order_type,
            'total' => $cart->total
        ]);
        return $order;
    }

    public function checkin(Request $request)
    {
        $restorant = Restorant::find($request->restorant_id);
        $areas = AreaResource::collection($restorant->areas);

        return inertia('Order/Checkout', compact(
            'restorant',
            'areas',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
