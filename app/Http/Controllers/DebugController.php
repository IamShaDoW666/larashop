<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\RestorantResource;
use App\Models\Category;
use App\Models\Config;
use App\Models\Product;
use App\Models\Restorant;
use Cknow\Money\Currency;
use Cknow\Money\Money;
use Spatie\OpeningHours\OpeningHours;


class DebugController extends Controller
{

  public function debug()
  {
    return inertia('Debug');
  }

  public function test()
  { 
    $product = Product::all();
    return $product;
  } 


  public function show($slug)
  {
    $restorant = Restorant::with('categories.products')
      ->where('slug', $slug)
      ->firstOrFail();
    return RestorantResource::make($restorant);
  }
}
