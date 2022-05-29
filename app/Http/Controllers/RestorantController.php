<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Restorant;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RestorantResource;
use App\Http\Resources\CategoryResource;

use App\Http\Requests\StoreRestorantRequest;
use App\Http\Requests\UpdateRestorantRequest;
use App\Models\Config;
use App\Services\ConfChanger;
use Spatie\Permission\Traits\HasRoles;

class RestorantController extends Controller
{
  private $imagePath = 'imgs/restorants/';
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $restorant = auth()->user()->restorant;
    $config = $restorant->config;
    if (auth()->user()->hasRole('Owner')) {
      return inertia('views/admin/Restorant', compact('restorant'));
    }

    if (auth()->user()->hasRole('Guest')) {
      return inertia('views/guest/Restorant');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return inertia('Restorant/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRestorantRequest $request)
  {
    $restorant = auth()->user()->restorant;
    if (!$restorant) {
      $restorant = Restorant::factory()->create($request->validated());
      $restorant->user()->associate(auth()->user()); $restorant->save();
      Config::create(['restorant_id' => $restorant->id]);
      auth()->user()->removeRole('Guest');
      auth()->user()->assignRole('Owner');
      return redirect(route('admin.dashboard'));;
    } else {
      abort(403, 'You have a restaurant');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($slug)
  {
    $restorant = Restorant::where('slug', $slug)
      ->with(['categories' => function ($q) {
        $q->whereHas('products');
      }])
      ->with('products')
      ->firstOrFail();
    ConfChanger::switchCurrency($restorant);
    $restaurant = RestorantResource::make($restorant);
    $products = ProductResource::collection($restaurant->products);
    return inertia('Restorant/Show', compact('restaurant', 'products'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //  
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRestorantRequest $request, $id)
  {
    $restorant = auth()->user()->restorant;
    //Need to validate if the owner is of the restorant
    $oldSlug = $restorant->slug; //Define the previous slug
    //Update Restaurant
    $restaurant = $restorant->update([
      'name' => $request->name,
      'phone' => $request->phone,
      'country' => $request->country,
      'address' => $request->address,
      'city' => $request->city,
      'postal_code' => $request->postal_code,
      'slug' => $request->slug
    ]);
    //Update Restorant Config
    $config = $restorant->config()->update([
      'can_deliver' => $request->can_deliver,
      'can_dinein' => $request->can_dinein,
      'can_pickup' => $request->can_pickup,
      'minimum_order' => $request->minimum_order,
      'currency' => $request->currency
    ]);
    //Rename Images Folder
    if (File::exists($this->imagePath . $oldSlug)) {
      $copyDirectory = File::copyDirectory(
        $this->imagePath . $oldSlug,
        $this->imagePath . $restorant->slug
      );
      $deleteDirectory = File::deleteDirectory($this->imagePath . $oldSlug);
    }

    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
