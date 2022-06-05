<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RestorantResource;
use App\Models\Category;
use App\Models\Config;
use App\Models\Hour;
use App\Models\Product;
use App\Models\Restorant;
use Cknow\Money\Currency;
use Cknow\Money\Money;
use Illuminate\Http\Request;
use Spatie\OpeningHours\OpeningHours;


class DebugController extends Controller
{

  public function debug()
  {
    return inertia('Debug');
  }

  public function post(Request $request)
  { 
    NewOrder::dispatch(auth()->user());
    return back();
  }


  public function show($slug)
  {
    $restorant = Restorant::with('categories.products')
      ->where('slug', $slug)
      ->firstOrFail();
    return RestorantResource::make($restorant);
  }
}
