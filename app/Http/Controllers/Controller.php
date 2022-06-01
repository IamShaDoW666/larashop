<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

use Webp;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function saveImageVersions($folder, $laravel_image_resource, $versions)
  {
    //If tinypng is set
    if (1 == 2) {
      //Go with tiny png
    } else {
      //Regular upload
      //Make UUID
      $uuid = Str::uuid()->toString();
      $webp = Webp::make($laravel_image_resource);

      //Make the versions
      foreach ($versions as $key => $version) {
        $ext = "jpg";
        if (isset($version['type'])) {
          $ext = $version['type'];
        }
        //Original image
        $img = Webp::make($laravel_image_resource);
        $img->save(public_path($folder) . $uuid . '_' . $version['name'] . '.' . 'webp');
        //$laravel_image_resource->move(public_path($folder), $uuid.'_'.$version['name'].'.'.'jpg');

      }

      return $uuid;
    }
  }
}
