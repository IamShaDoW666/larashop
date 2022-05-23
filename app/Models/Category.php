<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Restorant;
use App\Support\Collections\CategoryCollection;

class Category extends Model
{
  use HasFactory;
  protected $fillable = ['name', 'restorant_id'];
  protected $with = ['products'];

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function restorant()
  {
    return $this->belongsTo(Restorant::class);
  }

  // public function newColle ction(array $models = [])
  // {
  //   return new CategoryCollection($models);
  // }
}
