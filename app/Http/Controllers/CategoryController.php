<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Services\ConfChanger;
class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
      'name' => ['string']
    ]);
    $category = Category::create([
      'name' => $request->name,
      'grocery_id' => auth()->user()->grocery->id
    ]);
    $category->grocery()->associate(auth()->user()->grocery->id);
    $grocery = auth()->user()->grocery;
    ConfChanger::switchCurrency($grocery);
    // $store = groceryResource::make(grocery::with('categories.products')
    //   ->where('id', $grocery->id)
    //   ->first());

    $categories = Category::query()
      ->with('products')
      ->where('grocery_id', $grocery->id)
      ->get();
    $c = CategoryResource::collection($categories);
    return back()->with(['c' => $c]);
  }

  /**
   * Display the specified resource.x
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    if ($category->grocery_id != auth()->user()->grocery->id) {
      abort(404);
    }
    $request->validate([
      'name' => ['required', 'string']
    ]);
    $category->update(['name' => $request->name]);
    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    Product::where('category_id', $category->id)->delete();
    $category->delete();
    return back();
  }
}
