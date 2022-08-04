<?php

namespace App\Models;

use App\Http\Resources\OrderResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\Restorant;
use App\Services\ConfChanger;

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
    return $this->belongsToMany(Product::class)->withPivot(['quantity', 'variant_id', 'variant_name', 'variant_price']);
  }

  public function getSocialMessageAttribute($encode = false)
  {
    ConfChanger::switchCurrency($this->restorant);
    $message = view('messages.social', ['order' => $this])->render();
    $message = str_replace('&#039;', "'", $message);
    if ($encode) {
      $message = urlencode($message);
      return $message;
    }
    return $message;
  }
}
