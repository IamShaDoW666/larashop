<?php

namespace App\Models;

use App\Http\Resources\CategoryResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Area;
use App\Models\Product;
use App\Models\Order;
use App\Models\Config;
use App\Models\Category;

class Restorant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function categories()
    {
      return $this->hasMany(Category::class);
    }

    public function categoriesWithProducts()
    {
      return $this->hasMany(Category::class);
    }

    public function products()
    {
      return $this->hasManyThrough(Product::class, Category::class);
    }

    public function orders()
    {
      return $this->hasMany(Order::class);
    }

    public function areas()
    {
      return $this->hasMany(Area::class);
    }

    public function config()
    {
      return $this->hasOne(Config::class);
    }
}
