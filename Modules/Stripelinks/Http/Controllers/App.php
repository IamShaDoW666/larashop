<?php

namespace Modules\Stripelinks\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;


class App
{
    private $order;
    private $vendor;

    public function __construct($order, $vendor)
    {

        $this->order = $order;
        $this->vendor = $vendor;
    }

    public function execute()
    {
        config(['settings.stripe_secret' => $this->order->restorant->config->stripe_api_secret]);
        config(['settings.stripe_key' => $this->order->restorant->config->stripe_api_key]);
        \App\Services\ConfChanger::switchCurrency($this->order->restorant);

        Stripe::setApiKey(config('settings.stripe_secret'));
        $session = Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => config('global.currency'),
                    'product_data' => [
                        'name' => __('Order') . " #" . $this->order->id,
                    ],
                    'unit_amount' => (int)$this->order->total,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripelinks.success', ['ordermd' => md5($this->order->id)]),
            'cancel_url' => route('stripelinks.cancel', ['ordermd' => md5($this->order->id)]),
        ]);
        $this->order->payment_link = $session->url;
        return Validator::make([], []);
    }
}
