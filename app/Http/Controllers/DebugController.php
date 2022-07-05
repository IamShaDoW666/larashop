<?php

namespace App\Http\Controllers;


use App\Http\Resources\RestorantResource;
use App\Models\Restorant;
use App\Services\ConfChanger;
use Illuminate\Http\Request;
use Razorpay\Api\Api;



class DebugController extends Controller
{

  public function debug()
  {
    return inertia('Debug');
  }

  public function test()
  {
    $time = now();
    // $time->setTimezone('+5:30');
    return $time->format('g:i A');
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
