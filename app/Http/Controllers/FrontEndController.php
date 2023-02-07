<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\GroceryResource;
use App\Models\Conf;
use App\Models\Grocery;
use App\Services\ConfChanger;
use App\Services\GroceryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;

class FrontEndController extends Controller
{
    public function getSubDomain()
    {
        
        $subdomain = substr_count(str_replace('www.', '', $_SERVER['HTTP_HOST']), '.') > 1 ? substr(str_replace('www.', '', $_SERVER['HTTP_HOST']), 0, strpos(str_replace('www.', '', $_SERVER['HTTP_HOST']), '.')) : '';
        
        if ($subdomain == '' | in_array($subdomain, config('app.ignore_subdomains'))) {
            return false;
        }
        return $subdomain;
    }

    public function customDomainMode(){
        //1 - Make sure the module is installed
        // if(!in_array("domain", config('global.modules',[]))){
        //     return "";
        // }
        
        //2 - Extract the domain
        $domain = request()->getHost();
     
        $domainRemovedWWW = substr($domain, 4);
        // dd($domainRemovedWWW);
        //3 - Make sure, this is no the project domain itself,
        // if (strpos( config('app.url'),$domain) !== false) {
        //     return "";
        // }
        
        //4 - The extracted domain is in the list of custom values
        $theConfig=Conf::where('value',$domainRemovedWWW)->first();
        if (!$theConfig) {
            $theConfig=Conf::where('value', $domain)->first();          
        }
        
        if($theConfig){
           
            //5 - Return the company subdomain if company is active
            $vendor_id=$theConfig->model_id;

            $vendor=Grocery::where('id',$vendor_id)->first();
            //dd($theConfig, $vendor);
            if($vendor){
                return $this->grocery($vendor->slug);
            }else{
                return "";
            }
            
        }else{
            // dd('not ok');
            //By default return no domain
            return "";
        }

       


    }
   
    public function index()
    {        
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            return redirect()->route('LaravelInstaller::index');
        }
        return $this->customDomainMode();
    }

    public function singleMode()
    {        
        
        $domain = request()->getHost();
        $domainRemovedWWW = substr($domain, 4);
      //dd($domainRemovedWWW);
        //if (strpos( config('app.url'),$domain) !== false) {
            //return "";
        //}
        //$theConfig=Config::where('value',$domainRemovedWWW)->first();
       //dd('ok');
        $grocery = grocery::findOrFail(config('app.single_mode_id'));
        
        return $this->grocery($grocery->slug);
    }
    
    public function grocery($slug)
    {      
        //Set Table ID to session          
        if (request()->has('tid')) {
            session()->put('table_id', request()->tid);
        } else {
            session()->remove('table_id');
        }
        
        $grocery = grocery::where('slug', $slug)
            ->with(['categories' => function ($q) {
                $q->whereHas('products')->with('products.variants');
            }], 'config')
            ->with('hours')
            ->firstOrFail();
        $grocery->openStatus = GroceryService::getOpeningTime($grocery->hours);
        // return $grocery;
        
        ConfChanger::switchCurrency($grocery);
        $store = GroceryResource::make($grocery);
        $products = ProductResource::collection($grocery->categories->pluck('products')->flatten());
        // return $store;
        return inertia('Grocery/Show3', compact('store', 'products'));
    }
}
