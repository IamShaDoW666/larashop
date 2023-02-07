<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grocery;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'delivery_fee'];

    public function grocery()
    {
      return $this->belongsTo(grocery::class);
    }
}
