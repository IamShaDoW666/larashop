<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestorantResource;
use App\Models\Config;
use App\Models\Restorant;
use Illuminate\Http\Request;
use Cknow\Money\Currency;
use Cknow\Money\Money;

use Illuminate\Support\Facades\Config as FacadesConfig;

class DebugController extends Controller
{
  public function test(Request $request)
  {
    
  } 

  public function newtest()
  {
    $restorant = auth()->user()->restorant->loadMissing(['categories.products']);
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
