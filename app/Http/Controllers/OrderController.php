<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use App\Http\Resources\AreaResource;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\RestorantResource;
use App\Models\Product;
use App\Models\Order;
use App\Models\Restorant;
use App\Services\ConfChanger;
use Cknow\Money\Currency;
use Cknow\Money\Money;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restorant = Restorant::with('orders.products')
            ->find(auth()->user()->restorant->id);
        ConfChanger::switchCurrency($restorant);
        $restaurant = RestorantResource::make($restorant);
        return inertia('Order/Index', compact('restaurant'));
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


    public function store(StoreOrderRequest $request, Restorant $restorant)
    {
        ConfChanger::switchCurrency($restorant);
        $cart = $request->cart;
        $items_ids = array_column($cart['items'], 'quantity', 'id');
        $arr = array();
        foreach ($items_ids as $key => $items_id) {
            $arr[$key] = ['quantity' => $items_id];
        }
        $order = Order::factory()->create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'address' => $request->address,
            'order_type' => $request->order_type,
            'delivery_fee' => money($cart['delivery'], config('global.currency'), true)->getAmount(),
            'total' => money($cart['total'], config('global.currency'), true)->getAmount()
        ]);
        $order->restorant()->associate($restorant);
        $order->products()->sync($arr);
        $order->save();
        $message = $order->getSocialMessageAttribute(true);
        $url = 'https://api.whatsapp.com/send?phone=' . $order->restorant->phone . '&text=' . $message;
        return Inertia::location($url);
    }

    public function checkin($id)
    {
        $restorant_id = Crypt::decrypt($id);
        $restorant = Restorant::with('config')->find($restorant_id);
        ConfChanger::switchCurrency($restorant);
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

    public function sendWhatsappOrder($order)
    {
        $message = $order->getSocialMessageAttribute(true);
        $url = 'https://api.whatsapp.com/send?phone=' . $order->restorant->phone . '&text=' . $message;
        return Inertia::location($url);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $status = $request->current_status;
        $action = $request->action;

        // Check Reject 
        if (!$action && $status == 'pending') {
            $order->status = 'rejected';
            $order->save();
            return back()->with(['message' => 'Order Rejected!']);
        }

        // If positive action
        if ($action) {
            switch($status) {
                case 'pending':
                    $order->status = 'accepted';
                    $order->save();
                    break;
                case 'accepted':
                    $order->status = 'prepared';
                    $order->save();
                    break;
                case 'prepared':
                    $order->status = 'delivered';
                    $order->save();
                    break;
                case 'delivered':
                    $order->status = 'closed';
                    $order->save();
                    break;
            }

            return back()->with(['message' => 'Order status updated!']);
        }

    }
}  
