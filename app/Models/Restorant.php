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
use App\Models\Hour;
use App\Models\Category;
use App\Traits\HasConfig;
use Carbon\Carbon;

class Restorant extends Model
{
  use HasFactory, HasConfig;
  protected $guarded = [];
  public $modelName = 'App\Models\Restorant';
  // protected $appends = ['salesCount', 'counts', 'logo', 'banner'];

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
    return $this->hasMany(Order::class)->orderBy('created_at', 'desc');
  }

  public function areas()
  {
    return $this->hasMany(Area::class);
  }

  public function config()
  {
    return $this->hasOne(Config::class);
  }

  public function hours()
  {
    return $this->hasOne(Hour::class);
  }

  public function getSalesCountAttribute()
  {
    return $this->orders()
      ->where('status', 'closed')
      ->count();
  }

  public function getCountsAttribute()
  {
    return [
      'products' => $this->products()->count(),
      'categories' => $this->categories()->count(),
      'salesValue' => money(
        $this->orders()
          ->where('status', 'closed')
          ->sum('total'),
        $this->config->currency
      )->format()
    ];
  }
  public function getTodaySalesAttribute()
  {    
    return [
      'count' => $this->orders()
        ->where('status', 'closed')
        ->where('created_at', '>', Carbon::today())
        ->count(),
      'value' => money(
        $this->orders()
          ->where('status', 'closed')
          ->where('created_at', '>', Carbon::today())
          ->sum('total'),
        $this->config->currency
      )->format()
    ];
  }

  public function getYesterdaySalesAttribute()
  {
    return [
      'count' => $this->orders()
        ->where('status', 'closed')
        ->whereBetween('created_at', [Carbon::today()->subtract('day', 2), Carbon::today()])
        ->count(),
      'value' => money(
        $this->orders()
          ->where('status', 'closed')
          ->whereBetween('created_at', [Carbon::today()->subtract('day', 2), Carbon::today()])
          ->sum('total'),
        $this->config->currency
      )->format()
    ];
  }
}
