<?php   

return [
    'currency' => env('APP_CURRENCY', 'INR'),
    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY', ''),
    'confs' => '',
    'available_lang' => explode(",", env('AVAILABLE_LANG', 'en'))
];