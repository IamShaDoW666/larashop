<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Area;
use App\Models\Order;
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

    public function orders()
    {
      return $this->hasMany(Order::class);
    }

    public function areas()
    {
      return $this->hasMany(Area::class);
    }

    public function getCategoriesCountAttribute()
    {
      return $this->categories()->count();
    }

    public function getProductsCountAttribute()
    {
      $categoryIds = $this->categories->pluck('id');
      return Product::whereIn('category_id', $categoryIds)->count();
    }
}
