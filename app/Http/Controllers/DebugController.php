<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\RestorantResource;
use App\Models\Category;
use App\Models\Config;
use App\Models\Product;
use App\Models\Restorant;
use Illuminate\Http\Request;
use Cknow\Money\Currency;
use Cknow\Money\Money;

use Illuminate\Support\Facades\Config as FacadesConfig;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DebugController extends Controller
{

  public function debug()
  {
    $categories = CategoryResource::collection(Category::all());
    return inertia('Debug', compact('categories'));
  }

  public function test(Request $request)
  {
    $product = Product::all();
    return $product;
  } 

  public function newtest()
  {
    $categories = Category::only(['id', 'name']);
    dd($categories);
    return inertia('Debug', compact('restorant'));
  }

  public function show($slug)
  {
    $restorant = Restorant::with('categories.products')
      ->where('slug', $slug)
      ->firstOrFail();
    return RestorantResource::make($restorant);
  }
}
