<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restorant;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'delivery_fee'];

    public function restorant()
    {
      return $this->belongsTo(Restorant::class);
    }
}
