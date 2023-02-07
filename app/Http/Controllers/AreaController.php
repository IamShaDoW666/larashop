<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Resources\AreaResource;
use App\Models\Category;
use App\Services\ConfChanger;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $grocery = auth()->user()->grocery;
      //dd($grocery->areas);
      ConfChanger::switchCurrency($grocery);
      $areas = AreaResource::collection($grocery->areas);
      
      return inertia('Area/Index', compact('areas'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => ['required', 'string'],
        'delivery_fee' => ['required']
      ]);
      $area = Area::create([
        'name' => $request->name,
        'delivery_fee' => formatprice($request->delivery_fee)
      ]);
      $area->grocery()->associate(auth()->user()->grocery->id);
      $area->save();
      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
      $request->validate([
        'name' => ['required', 'string'],
        'delivery_fee' => ['required']
      ]);

      $area->update([
        'name' => $request->name,
        'delivery_fee' => formatprice($request->delivery_fee)
      ]);
      
      return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
      $area->delete();
      return back();
    }    
}
