<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Http\Resources\RestorantResource;
use App\Models\Restorant;
use App\Services\ConfChanger;
use App\Services\RestorantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function index()
    {
        try {
            \DB::connection()->getPdo();
        } catch (\Exception $e) {
            return redirect()->route('LaravelInstaller::index');
        }
        return $this->singleMode();
    }

    public function singleMode()
    {        
        $restorant = Restorant::findOrFail(config('app.single_mode_id'));

        return $this->restorant($restorant->slug);
    }

    public function restorant($slug)
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
}
