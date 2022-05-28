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


class DebugController extends Controller
{

  public function debug()
  {
    $categories = CategoryResource::collection(Category::all());
    return inertia('Debug', compact('categories'));
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
