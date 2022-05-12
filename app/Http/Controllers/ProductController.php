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
use Image;

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
    $categories = Category::where('restorant_id', auth()->user()->restorant->id)->get();

    $products = collect();
    $collection = $categories->each(function($category) use ($products) {
      return $products->push($category->products);
    });
    $categories = CategoryResource::collection($categories);
    return inertia('Product/Index', compact('categories', 'collection'));
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
      //Check if folder exists and make if not
      $imgpath = $this->uploadimage($request->product_image);
    }
    //Create Product
    if (!isset($imgpath)) {
      $imgpath = 'default';
    }

    $product = Product::create([
      'name' => $request->name,
      'description' => $request->description,
      'price' => $this->formatprice($request->price),
      'image' => $imgpath,
    ]);

    //Assign Category
    $category = Category::where('id', $request->category['id'])->first();
    $product->category()->associate($category)->save();
    $product = new ProductResource($product);
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
      'price' => $this->formatprice($request->price),
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
    $products = Product::where('category_id', $id)->get();
    if (!empty($products)) {
      return ProductResource::collection($products);
    } else {
      throw Exception("Error Processing Request", 404);

    }

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
