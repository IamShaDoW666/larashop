<?php

namespace App\Models;

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
    protected $appends = ['counts'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function categories()
    {
      return $this->hasMany(Category::class);
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

    public function getCountsAttribute()
    {
      $categoryIds = $this->categories->pluck('id');
      $categories_count = $categoryIds->count();
      $products_count = Product::whereIn('category_id', $categoryIds)->count();
      return [
        'categories_count' => $categories_count,
        'products_count' => $products_count
      ];
    }
}
