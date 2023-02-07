<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Grocery;
class Hour extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function grocery()
    {
        return $this->belongsTo(grocery::class);
    }
}
