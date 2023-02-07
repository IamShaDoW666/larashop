<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanResource;
use App\Models\Plan;


use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {        
        $plans = PlanResource::collection(Plan::all());        
        return inertia('Plan/Index', compact('plans'));
    }

    public function store(Request $request)
    {            
      // $request->validate([
      //   'name' => ['required', 'string'],
      //   'items' => ['required'],
      //   'price' => ['required','integer']
      // ]);
      //dd(request()->all());
      $plan = Plan::create([
        'name' => $request->name,     
        'items' => $request->items,
        'price' => formatprice($request->price)
        
      ]);      
      return back();
    }




    public function destroy(Plan $plan)
    {
        $plan->delete();
        return back();
    }

    public function update(Request $request, Plan $plan)
    {
      
      $request->validate([
        'name' => ['required', 'string'],
        'price' => ['required'],
        'items'=> ['required']
      ]);

      $plan->update([
        'name' => $request->name,
        'price' => money($request->price, env('APP_CURRENCY'), true)->getAmount(),
        'items' => $request->items
      ]);
      
      return back();
    }





}
