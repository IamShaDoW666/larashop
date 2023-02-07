<?php

namespace App\Listeners;
use App\Listeners\Order;
use App\Events\NewOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BulkWhatsapp
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    private function saveNumber($order, $api_key)

    {
       
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $config = $order->grocery->config;
        $api_key =  $config->bulk_whatsapp_api_key; 
       
        $data = [
            'api_key' => $api_key,
            'number' => preg_replace('/\D/', '', $order->customer_phone),
            'name' => $order->customer_name,
            'group' => 'Group1'
        ];

        $payload = [
            'form_params' => $data
        ];
        $response = $client->request('POST', 'http://65.2.191.198/save-number', $payload);        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewOrder $event)
    {
        $order = $event->order; 
        // dd($order);
        $config = $order->grocery->config;
        
        $url=config('app.url')  . '/order/status/' . $order->id;
        $api_key =  $config->bulk_whatsapp_api_key;
                      
                       
        $data = [
            'api_key' => $api_key,
           
           'sender' => preg_replace('/\D/', '', $order->grocery->phone),
           'number' => preg_replace('/\D/', '', $order->customer_phone),
          
           
            'message' => $url,
           
            'footer' => 'Thank you for your order.You can track your order ',
            'image' => 'https://spotfood.in/uploads/settings/6d975f6a-99df-4959-b6c6-b32e3046d562_site_logo_dark.jpg', //OPTIONAL
            
            'template1' => 'call|Callme|7012749946', //REQUIRED ( template minimal 1 )
            'template2' => 'url|Track|' . $url, //OPTIONAL
            
        ];
        $payload = [
            'form_params' => $data
        ];                

        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $client->request('POST', 'http://65.2.191.198/send-template', $payload);

        //Save Number
        if(strlen($api_key)>5){
            $this->saveNumber($order, $api_key);
        }
    }
}
