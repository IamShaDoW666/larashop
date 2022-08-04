<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use App\Services\ConfChanger;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function store(Request $request, Product $product)
    {        
        ConfChanger::switchCurrency($product->category->restorant);
        $variant = Variant::create([
            'name' => $request->name,
            'price' => money($request->price, config('global.currency'), true)->getAmount()
        ]);
        $product->variants()->save($variant);
        $product->save();
        return back();
    }

    public function destroy(Variant $variant)
    {
        $variant->delete();
        return back();
    }

    public function update(Request $request, Variant $variant)
    {
        ConfChanger::switchCurrency($variant->product->category->restorant);
        $variant = $variant->update([
            'name' => $request->name,
            'price' => money($request->price, config('global.currency'), true)->getAmount()
        ]);
        return back();
    }
}
