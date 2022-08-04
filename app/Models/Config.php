<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restorant;

class Config extends Model
{
    use HasFactory;
    protected $guarded = [];    

    public function restorant()
    {
        return $this->belongsTo(Restorant::class);
    }
}
