<?php

namespace App\Services;



class ConfChanger
{
    public static function switchCurrency($restaurant)
    {
        if (strlen($restaurant->config->currency) > 1) {
            config(['global.currency' => $restaurant->config->currency]);
        }
    }

    public static function switchGoogleMapsApiKey($restaurant)
    {
        if (strlen($restaurant->config->google_maps_api_key) > 1) {
            config(['global.google_maps_api_key' => $restaurant->config->google_maps_api_key]);
        }
    }

    public static function setConfs($restaurant)
    {
        if ($restaurant->config) {
            config(['global.conf' => $restaurant->config]);
        }
    }




    // public static function switchLanguage($restaurant)
    // {

    //     //If we have enabled miltilanguage_menus
    //     if (config('settings.enable_miltilanguage_menus')) {
    //         //If we want to change the menu
    //         if (isset($_GET['lang'])) {
    //             //3. Change locale to the new local
    //             app()->setLocale($_GET['lang']);
    //             session(['applocale_change' => $_GET['lang']]);
    //         } else {
    //             //If current locale is not in the list of menus, use the default menu
    //             if ($restaurant->localMenus()->where('language', config('app.locale'))->first() == null) {
    //                 //Find default
    //                 $defaultLanguage = $restaurant
    //                     ->localMenus()->where('default', 1)->first();
    //                 if ($defaultLanguage) {
    //                     app()->setLocale($defaultLanguage->language);
    //                     session(['applocale_change' => $defaultLanguage->language]);
    //                 }
    //             }
    //         }
    //     }
    // }
}
