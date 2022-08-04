<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'image', 'image_path'];
    // protected $appends = ['imglarge'];
    protected $imagePath = '/imgs/restorants/';

    protected function getImge($imageValue, $default, $version = '_large.jpg')
    {
      if ($imageValue == '' || $imageValue == null) {
        //No image
        return $default;
      } else {
        if (strpos($imageValue, 'http') !== false) {
          //Have http
          if (strpos($imageValue, '.jpg') !== false || strpos($imageValue, '.jpeg') !== false || strpos($imageValue, '.png') !== false) {
            //Has extension
            return $imageValue;
          } else {
            //No extension
            return $imageValue.$version;
          }
        } else {
          //Local image
          return ($this->imagePath.$this->category->restorant->slug.'/'.$imageValue).$version;
        }
      }
    }

    // public function getImgLargeAttribute()
    // {
    //   if ($this->image != 'default') {
    //     return $this->getImge($this->image, 'default');
    //   }
    //   else {
    //     return $this->imagePath.'default_large.jpg';
    //   }
    // }

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function variants()
    {
      return $this->hasMany(Variant::class);
    }
}