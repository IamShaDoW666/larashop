<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grocery;

class Table extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'number', 'grocery_id'];    

    public function grocery()
    {
      return $this->belongsTo(grocery::class);
    }
    
}
