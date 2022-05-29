<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\RestorantResource;
use App\Models\Restorant;
use App\Services\ConfChanger;
use Image;

use Cknow\Money\Currency;
use Cknow\Money\Money;

class ProductController extends Controller
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
    ConfChanger::switchCurrency($restorant);
    $restaurant = RestorantResource::make(Restorant::with('categories.products')
      ->get()
      ->find($restorant->id));
    return inertia('Product/Index', compact('restaurant'));
  }

  /** 
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    $categories = Category::all();
    $products = ProductResource::collection(Product::all());
    return inertia('Product/Create', compact('products', 'categories'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
public function store(StoreProductRequest $request)
  {
    //Save Image Versions
    if ($request->hasFile('product_image')) {
      $imgpath = $this->uploadimage($request->product_image);
    }
    if (!isset($imgpath)) {
      $imgpath = 'default';
    }
    //Create Product
    $product = Product::create([
      'name' => $request->name,
      'description' => $request->description,
      'price' => money($request->price, config('global.currency'), true)->getAmount(),
      'image' => $imgpath,
    ]);

    //Assign Category
    $category = Category::where('id', $request->category['id'])->first();
    $product->category()->associate($category)->save();
    return back();
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function show(Product $product)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function edit(Product $product)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function update(UpdateProductRequest $request, Product $product)
  {
    if (auth()->user()->id != $product->category->restorant->user_id) {
      abort(403);
    }

    if ($request->hasFile('product_image')) {
      $imgpath = $this->uploadimage($request->product_image);
    } else {
      $imgpath = $product->image;
    }
    $data = [
      'name' => $request->name,
      'description' => $request->description,
      'price' => money($request->price, env('APP_CURRENCY'), true)->getAmount(),
      'image' => $imgpath
    ];
    $product->update($data);

    $category = Category::where('id', $request->category['id'])->first();
    $product->category()->associate($category)->save();
    return back();
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function destroy(Product $product)
  {
    // dd($product);
    $product->delete();
    return back();
  }

  public function filter($id)
  {
    $restaurant = Category::findOrFail($id)->restorant;
    ConfChanger::switchCurrency($restaurant);
    return ProductResource::collection(Product::where('category_id', $id)->get());
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

  private function uploadimage($image)
  {
    //Check if folder exists and make if not
    if (!File::exists($this->imagePath.auth()->user()->restorant->slug)) {
      File::makeDirectory($this->imagePath.auth()->user()->restorant->slug, $mode = 0777, true, true);
    }
    //Save Image
    return $this->saveImageVersions(
      $this->imagePath.auth()->user()->restorant->slug.'/',
      $image,
      [
        ['name'=>'large', 'w'=>590, 'h'=>400],
        //['name'=>'thumbnail','w'=>300,'h'=>300],
        ['name'=>'medium', 'w'=>295, 'h'=>200],
        ['name'=>'thumbnail', 'w'=>200, 'h'=>200],
      ]
    );
  }

}
