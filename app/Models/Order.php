<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\Restorant;

class Order extends Model
{
    use HasFactory;

    public function checkout()
    {
      return $this->hasOne(Checkout::class);
    }

    public function restorant()
    {
      return $this->belongsTo(Restorant::class);
    }

    public function products()
    {
      return $this->belongsToMany(Product::class);
    }
}
