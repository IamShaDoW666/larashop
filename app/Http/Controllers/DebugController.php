<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\groceryResource;
use App\Models\Order;
use App\Models\grocery;
use App\Services\ConfChanger;
use App\Services\groceryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Razorpay\Api\Api;



class DebugController extends Controller
{

  public function debug()
  {
    // session(['order_token' => Crypt::encrypt('3')]);
    // dd(Crypt::decrypt($cipher), config('app.url') . '/order/status/' . $cipher);
    // return config('app.url') . '/order/status/' . $order_id;
    return inertia('Debug');
  }

  public function test(Order $order)
  {
    dd(session()->all());
  }

  public function post(Request $request)
  {
    $grocery = grocery::findOrFail($request->grocery);
    ConfChanger::switchCurrency($grocery);
    $values = [
      'receipt' => 'Payment',
      'amount' => $request->amount * 100,
      'currency' => config('global.currency')
    ];    
    $api = new Api($grocery->config->razorpay_api_key, $grocery->config->razorpay_api_secret);
    $order = $api->order->create($values);
    return response($order->id);
  }


  public function show($slug)
  {
    $grocery = grocery::with('categories.products')
      ->where('slug', $slug)
      ->firstOrFail();
    return groceryResource::make($grocery);
  }
}
