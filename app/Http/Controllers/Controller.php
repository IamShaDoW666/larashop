<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

use Image;

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

      //Make the versions
      foreach ($versions as $key => $version) {
        $ext = "jpg";
        if (isset($version['type'])) {
          $ext = $version['type'];
        }
        if (isset($version['w']) && isset($version['h'])) {
          if ($ext == 'webp') {
            $img = Image::make($laravel_image_resource->getRealPath())->fit($version['w'], $version['h'])->encode('webp', $version['quality']);
            $img->save(public_path($folder) . $uuid . '_' . $version['name'] . '.' . $ext, $version['quality'], $ext);
          } else {
            $img = Image::make($laravel_image_resource->getRealPath())->fit($version['w'], $version['h']);
            $img->save(public_path($folder) . $uuid . '_' . $version['name'] . '.' . $ext, $version['quality'], $ext);
          }
        } else {
          //Original image
          $img = Image::make($laravel_image_resource->getRealPath())->encode('webp', $version['quality']);
          $img->save(public_path($folder) . $uuid . '_' . $version['name'] . '.' . $ext, $version['quality'], $ext);
        }
      }

      return $uuid;
    }
  }
}
