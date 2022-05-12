<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Resources\AreaResource;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $areas = AreaResource::collection(auth()->user()->restorant->areas);
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
        'delivery_fee' => $this->formatprice($request->delivery_fee)
      ]);
      $area->restorant()->associate(auth()->user()->restorant->id);
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
        'delivery_fee' => $this->formatprice($request->delivery_fee)
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

    private function formatprice($price)
    {
      $formatArray = explode(".", $price);
      if (sizeof($formatArray) > 1) {
        $formatArray[0] = (int)$formatArray[0].'00';
        $formattedPrice = (int)$formatArray[0] + (int)$formatArray[1];
        return $formattedPrice;

      } else {
        $formattedPrice = $formatArray[0].'00';
        return (int)$formattedPrice;
      }
    }

}
