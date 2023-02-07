<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Grocery;
use App\Http\Resources\ProductResource;
use App\Http\Resources\groceryResource;
use App\Http\Requests\StoregroceryRequest;
use App\Http\Requests\UpdategroceryRequest;
use App\Http\Resources\PlanResource;
use App\Models\Config;
use App\Models\Hour;
use App\Models\Plan;
use App\Services\ConfChanger;
use App\Services\groceryService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Nwidart\Modules\Facades\Module;
class GroceryController extends Controller
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
      $confs = auth()->user()->grocery->getAllConfigs();
      return inertia('views/admin/Grocery', compact('confs'));
    }

    if (auth()->user()->hasRole('Guest')) {
      return inertia('views/guest/Grocery');
    }
    // $groceries = Grocery::all();
    // return inertia('views/super/Groceries', compact('groceries'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return inertia('Grocery/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoregroceryRequest $request)
  {
    $grocery = auth()->user()->grocery;
    if (!$grocery) {
      $grocery = grocery::factory()->create($request->validated());
      $grocery->user()->associate(auth()->user());

      $grocery->save();
      Config::create(['grocery_id' => $grocery->id]);
      Hour::create(['grocery_id' => $grocery->id]);
      auth()->user()->removeRole('Guest');
      auth()->user()->assignRole('Owner');
      return redirect(route('admin.dashboard'));;
    } else {
      abort(403, 'You have a store');
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
    $grocery = grocery::where('slug', $slug)
      ->with(['categories' => function ($q) {
        $q->whereHas('products')->with('products.variants');
      }], 'config')
      ->with('hours')
      ->firstOrFail();
    $grocery->openStatus = groceryService::getOpeningTime($grocery->hours);
    // return $grocery;
    ConfChanger::switchCurrency($grocery);
    $store = groceryResource::make($grocery);
    $products = ProductResource::collection($grocery->categories->pluck('products')->flatten());
    // return $store;
    return inertia('Grocery/Show', compact('store', 'products'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $grocery = Grocery::findOrFail($id);
  }

  public function loginShow(Request $request)
  {    
    $grocery = Grocery::findOrFail($request->id);
    Session::put('impersonate', $grocery->user->id);    
    return redirect()->route('admin.dashboard');
  }

  public function stopImpersonate()
  {

    auth()->user()->stopImpersonating();

    return redirect()->route('super.dashboard');
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdategroceryRequest $request, $id)
  {
    if (auth()->user()->hasRole('SuperAdmin')) {
      $grocery = Grocery::findOrFail($id);
    } else {
      $grocery = auth()->user()->grocery;
    }
    //check for images
    if ($request->hasFile('banner')) {
      $bannerImg = $this->uploadbanner($request->banner);
    } else {
      $bannerImg = $grocery->banner;
    }

    if ($request->hasFile('logo')) {
      $logoImg = $this->uploadlogo($request->logo);
    } else {
      $logoImg = $grocery->logo;
    }

    //Need to validate if the owner is of the grocery
    $oldSlug = $grocery->slug; //Define the previous slug
    //Update store
    $store = $grocery->update([
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
      'banner' => ($bannerImg != $grocery->banner) ? $this->imagePath . $bannerImg : $bannerImg,
      'logo' => ($logoImg != $grocery->logo) ? $this->imagePath . $logoImg : $logoImg
    ]);
    //Update grocery Config
    $config = $grocery->config()->update([
      'can_deliver' => $request->can_deliver,
      'can_dinein' => $request->can_dinein,
      'can_pickup' => $request->can_pickup,
      'minimum_order' => $request->minimum_order ?? 0,
      'currency' => $request->currency
    ]);

    if ($request->delivery_info) {
      $grocery->setConfig('delivery_info', $request->delivery_info);
    }
    //Rename Images Folder
    // if (File::exists($this->imagePath . $oldSlug)) {
    //   $copyDirectory = File::copyDirectory(
    //     $this->imagePath . $oldSlug,
    //     $this->imagePath . $grocery->slug
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
    $grocery = Grocery::findOrFail($id);
    $grocery->user->removeRole('Owner');
    $grocery->user->assignRole('Guest');
    $grocery->delete();
    return back();
  }

  public function share()
  {
    return inertia('Grocery/Share');
  }

  public function workingHours()
  {
    $hours = Hour::where('grocery_id', auth()->user()->grocery->id)->first();
    return inertia('Grocery/WorkingHours', compact('hours'));
  }

  public function updateWorkingHours(Request $request, grocery $grocery)
  {
    $grocery->hours->update($request->all());
    return back()->with(['message' => 'Updated Successfully!']);
  }

  public function location()
  {
    ConfChanger::switchGoogleMapsApiKey(auth()->user()->grocery);
    $googleMapsApiKey = config('global.google_maps_api_key');
    return inertia('Grocery/Location', compact('googleMapsApiKey'));
  }

  public function setLocation(Request $request, grocery $grocery)
  {
    $grocery->lat = $request->lat;
    $grocery->lng = $request->lng;
    $grocery->save();
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
        ['name' => 'large', 'w' => 800, 'h' => 800, 'type' => 'webp', 'quality' => 100],
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
    return inertia('Grocery/Apps', compact('hasTaxConfig'));
  }

  public function updateApps(Request $request, grocery $grocery)
  {    
    $grocery->config->update([
      'tax' => $request->tax,
      'tax_name' => $request->tax_name,
      'google_maps_api_key' => $request->google_maps_api_key,
      'bulk_whatsapp_api_key' => $request->bulk_whatsapp_api_key,      
    ]);    
    $grocery->setConfig('custom_domain_name', $request->custom_domain_name);

    return back();
  }

  public function payments()
  {
    $config = auth()->user()->grocery->config;
    $razorpay_data = [
      'razorpay_api_key' => $config->razorpay_api_key,
      'razorpay_api_secret' => $config->razorpay_api_secret,
    ];
    return inertia('Grocery/Payments', compact('razorpay_data'));
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
    $grocery = auth()->user()->grocery;
    $mail_host = $grocery->getConfig('MAIL_HOST');
    $mail_port = $grocery->getConfig('MAIL_PORT');
    $mail_username = $grocery->getConfig('MAIL_USERNAME');
    $mail_password = $grocery->getConfig('MAIL_PASSWORD');
    $mail_encryption = $grocery->getConfig('MAIL_ENCRYPTION');
    $mail_from_address = $grocery->getConfig('MAIL_FROM_ADDRESS');

    $data = [
      'mail_host' => $mail_host,
      'mail_port' => $mail_port,
      'mail_username' => $mail_username,
      'mail_password' => $mail_password,
      'mail_encryption' => $mail_encryption,
      'mail_from_address' => $mail_from_address,
    ];
    return inertia('Grocery/Smtp', compact('data'));
  }

  public function updateSmtp(Request $request, Grocery $grocery)
  {
    $grocery->setMultipleConfig($request->all());
    $this->setEnvironmentValue($request->all());
    return back();
  }

  public function plan()
  {                     
    $currentPlan = auth()->user()->grocery->plan->first();        
    $plans = PlanResource::collection(Plan::all());    
    return inertia('Grocery/Plan', compact('plans', 'currentPlan'));
  }

  public function assignPlan(Request $request, Grocery $grocery)
  {    
    $plan = Plan::findOrFail($request->plan);    
    $grocery->plan()->detach();
    $grocery->plan()->attach($request->plan);
    return back();
  }

  public function removePlan(Grocery $grocery)
  {        
    $grocery->plan()->detach();    
    return back();
  }

}
