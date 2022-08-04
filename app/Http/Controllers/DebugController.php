<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\RestorantResource;
use App\Models\Order;
use App\Models\Restorant;
use App\Services\ConfChanger;
use App\Services\RestorantService;
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
    ConfChanger::switchCurrency(Restorant::find($request->restorant));
    $values = [
      'receipt' => 'Payment',
      'amount' => $request->amount * 100,
      'currency' => config('global.currency')
    ];
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    $order = $api->order->create($values);
    return response($order->id);
  }


  public function show($slug)
  {
    $restorant = Restorant::with('categories.products')
      ->where('slug', $slug)
      ->firstOrFail();
    return RestorantResource::make($restorant);
  }
}
