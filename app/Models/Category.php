<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Restorant;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'restorant_id'];

    public function products()
    {
      return $this->hasMany(Product::class);
    }

    public function restorant()
    {
      return $this->belongsTo(Restorant::class);
    }

}
