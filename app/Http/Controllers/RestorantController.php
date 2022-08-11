<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restorant;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RestorantResource;

use App\Http\Requests\StoreRestorantRequest;
use App\Http\Requests\UpdateRestorantRequest;
use App\Models\Config;
use App\Models\Hour;
use App\Models\Product;
use App\Services\ConfChanger;
use App\Services\RestorantService;
use Nwidart\Modules\Facades\Module;

class RestorantController extends Controller
{
  private $imagePath = '/imgs/';
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (auth()->user()->hasRole('Owner')) {
      $confs = Restorant::find(1)->getAllConfigs();
      return inertia('views/admin/Restorant', compact('confs'));
    }

    if (auth()->user()->hasRole('Guest')) {
      return inertia('views/guest/Restorant');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return inertia('Restorant/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRestorantRequest $request)
  {
    $restorant = auth()->user()->restorant;
    if (!$restorant) {
      $restorant = Restorant::factory()->create($request->validated());
      $restorant->user()->associate(auth()->user());
      $restorant->save();
      Config::create(['restorant_id' => $restorant->id]);
      Hour::create(['restorant_id' => $restorant->id]);
      auth()->user()->removeRole('Guest');
      auth()->user()->assignRole('Owner');
      return redirect(route('admin.dashboard'));;
    } else {
      abort(403, 'You have a restaurant');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($slug)
  {
    $restorant = Restorant::where('slug', $slug)
      ->with(['categories' => function ($q) {
        $q->whereHas('products')->with('products.variants');
      }], 'config')
      ->with('hours')
      ->firstOrFail();
    $restorant->openStatus = RestorantService::getOpeningTime($restorant->hours);
    // return $restorant;
    ConfChanger::switchCurrency($restorant);
    $restaurant = RestorantResource::make($restorant);
    $products = ProductResource::collection($restorant->categories->pluck('products')->flatten());
    // return $restaurant;
    return inertia('Restorant/Show', compact('restaurant', 'products'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //  
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRestorantRequest $request, $id)
  {
    $restorant = auth()->user()->restorant;
    //check for images
    if ($request->hasFile('banner')) {
      $bannerImg = $this->uploadbanner($request->banner);
    } else {
      $bannerImg = $restorant->banner;
    }

    if ($request->hasFile('logo')) {
      $logoImg = $this->uploadlogo($request->logo);
    } else {
      $logoImg = $restorant->logo;
    }

    //Need to validate if the owner is of the restorant
    $oldSlug = $restorant->slug; //Define the previous slug
    //Update Restaurant
    $restaurant = $restorant->update([
      'name' => $request->name,
      'phone' => $request->phone,
      'country' => $request->country,
      'address' => $request->address,
      'city' => $request->city,
      'postal_code' => $request->postal_code,
      'slug' => $request->slug,
      'instagram' => $request->instagram,
      'facebook' => $request->facebook,
      'twitter' => $request->twitter,
      'banner' => ($bannerImg != $restorant->banner) ? $this->imagePath . $bannerImg : $bannerImg,
      'logo' => ($logoImg != $restorant->logo) ? $this->imagePath . $logoImg : $logoImg
    ]);
    //Update Restorant Config
    $config = $restorant->config()->update([
      'can_deliver' => $request->can_deliver,
      'can_dinein' => $request->can_dinein,
      'can_pickup' => $request->can_pickup,
      'minimum_order' => $request->minimum_order ?? 0,
      'currency' => $request->currency
    ]);

    if ($request->delivery_info) {
      $restorant->setConfig('delivery_info', $request->delivery_info);
    }
    //Rename Images Folder
    // if (File::exists($this->imagePath . $oldSlug)) {
    //   $copyDirectory = File::copyDirectory(
    //     $this->imagePath . $oldSlug,
    //     $this->imagePath . $restorant->slug
    //   );
    //   $deleteDirectory = File::deleteDirectory($this->imagePath . $oldSlug);
    // }

    return back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function share()
  {
    return inertia('Restorant/Share');
  }

  public function workingHours()
  {
    $hours = Hour::where('restorant_id', auth()->user()->restorant->id)->first();
    return inertia('Restorant/WorkingHours', compact('hours'));
  }

  public function updateWorkingHours(Request $request, Restorant $restorant)
  {
    $restorant->hours->update($request->all());
    return back()->with(['message' => 'Updated Successfully!']);
  }

  public function location()
  {
    ConfChanger::switchGoogleMapsApiKey(auth()->user()->restorant);
    $googleMapsApiKey = config('global.google_maps_api_key');
    return inertia('Restorant/Location', compact('googleMapsApiKey'));
  }

  public function setLocation(Request $request, Restorant $restorant)
  {
    $restorant->lat = $request->lat;
    $restorant->lng = $request->lng;
    $restorant->save();
    return back()->with(['message' => 'Done!']);
  }

  private function uploadimage($image)
  {
    //Save Image
    return $this->saveImageVersions(
      $this->imagePath,
      $image,
      [
        ['name' => 'xl', 'w' => 500, 'h' => 480, 'type' => 'webp', 'quality' => 100],
        ['name' => 'thumbnail', 'w' => 200, 'h' => 200, 'type' => 'webp', 'quality' => 100],
      ]
    );
  }

  private function uploadbanner($image)
  {
    return $this->saveImageVersions(
      $this->imagePath,
      $image,
      [
        ['name' => 'large', 'w' => 2648, 'h' => 768, 'type' => 'webp', 'quality' => 100],
      ]
    );
  }

  private function uploadlogo($image)
  {
    return $this->saveImageVersions(
      $this->imagePath,
      $image,
      [
        ['name' => 'logo', 'w' => 200, 'h' => 200, 'type' => 'webp', 'quality' => 100],
      ]
    );
  }

  public function apps()
  {
    $hasTaxConfig = Module::has('TaxConfig');
    return inertia('Restorant/Apps', compact('hasTaxConfig'));
  }

  public function updateApps(Request $request, Restorant $restorant)
  {    
    $restorant->config->update([
      'tax' => $request->tax,
      'tax_name' => $request->tax_name,
      'google_maps_api_key' => $request->google_maps_api_key
    ]);

    return back();
  }

  public function payments()
  {
    return inertia('Restorant/Payments');
  }
  public function setEnvironmentValue(array $values)
  {
    $envFile = app()->environmentFilePath();
    $str = "\n";
    $str .= file_get_contents($envFile);
    $str .= "\n"; // In case the searched variable is in the last line without \n
    if (count($values) > 0) {
      foreach ($values as $envKey => $envValue) {
        if ($envValue == trim($envValue) && strpos($envValue, ' ') !== false) {
          $envValue = '"' . $envValue . '"';
        }

        $keyPosition = strpos($str, "{$envKey}=");
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

        // If key does not exist, add it
        if ((!$keyPosition && $keyPosition != 0) || !$endOfLinePosition || !$oldLine) {
          $str .= "{$envKey}={$envValue}\n";
        } else {
          if ($envKey == "DB_PASSWORD") {
            $str = str_replace($oldLine, "{$envKey}=\"{$envValue}\"", $str);
          } else {
            $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
          }
        }
      }
    }

    $str = substr($str, 1, -1);
    if (!file_put_contents($envFile, $str)) {
      return false;
    }

    return true;
  }
  public function smtp()
  {
    $restorant = auth()->user()->restorant;
    $mail_host = $restorant->getConfig('MAIL_HOST');
    $mail_port = $restorant->getConfig('MAIL_PORT');
    $mail_username = $restorant->getConfig('MAIL_USERNAME');
    $mail_password = $restorant->getConfig('MAIL_PASSWORD');
    $mail_encryption = $restorant->getConfig('MAIL_ENCRYPTION');
    $mail_from_address = $restorant->getConfig('MAIL_FROM_ADDRESS');

    $data = [
      'mail_host' => $mail_host,
      'mail_port' => $mail_port,
      'mail_username' => $mail_username,
      'mail_password' => $mail_password,
      'mail_encryption' => $mail_encryption,
      'mail_from_address' => $mail_from_address,
    ];
    return inertia('Restorant/Smtp', compact('data'));
  }

  public function updateSmtp(Request $request, Restorant $restorant)
  {
    $restorant->setMultipleConfig($request->all());
    $this->setEnvironmentValue($request->all());
    return back();
  }
}
