<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'items'];

    public function groceries() 
    {
        return $this->belongsToMany(Grocery::class);
    }
}