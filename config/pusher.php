<?php
//check if all values below exists
$exists = true;
if (!env('PUSHER_APP_ID') || !env('PUSHER_APP_KEY') || !env('PUSHER_APP_SECRET') || !env('PUSHER_APP_CLUSTER')) {
    $exists = false;
}

return [
    'app_id' => env('PUSHER_APP_ID'),
    'app_key' => env('PUSHER_APP_KEY'),
    'app_cluster' => env('PUSHER_APP_CLUSTER'),
    'app_secret' => env('PUSHER_APP_SECRET'),
    'exists' => $exists
];
