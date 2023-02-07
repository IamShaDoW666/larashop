<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Grocery;
use App\Support\Collections\CategoryCollection;

class Category extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'grocery_id'];
  protected $with = ['products'];

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function grocery()
  {
    return $this->belongsTo(grocery::class);
  }

  // public function newColle ction(array $models = [])
  // {
  //   return new CategoryCollection($models);
  // }
}
