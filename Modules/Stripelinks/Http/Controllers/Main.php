<?php
namespace Modules\Stripelinks\Http\Controllers;
use App\Models\Order;
use App\Services\ConfChanger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
class Main extends Controller
{
    /**
     * @var Order order - The order
     */
    public $order;
    public function onSiteStripeCheckout(Order $order)
    {
        $this->order = $order;
        //dd($order);
        $total_price = (int) (($order->order_price_with_discount + $order->delivery_price) * 100);
        config(['settings.stripe_secret' => $this->order->restorant->getConfig('stripe_secret', '')]);
        config(['settings.stripe_key' => $this->order->restorant->getConfig('stripe_key', '')]);
        \App\Services\ConfChanger::switchCurrency($this->order->restorant);

        Stripe::setApiKey(config('settings.stripe_secret'));
        $session = Session::create([
            // 'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => config('settings.cashier_currency'),
                    'product_data' => [
                    'name' => __('Order') . " #" . $order->id,
                    ],
                    'unit_amount' => $total_price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripelinks.success', ['ordermd' => md5($order->id)]),
            'cancel_url' => route('stripelinks.cancel', ['ordermd' => md5($order->id)]),
        ]);

        return redirect($session->url);
    }

    public function success($ordermd)
    {
        // dd($ordermd);
        //Find the order
        $order = Order::where('uuid', $ordermd)->first();        
        if ($order) {
            // $order->payment_status = 'paid';
            $order->update();
            $message = $order->getSocialMessageAttribute(true);
            $url = 'https://api.whatsapp.com/send?phone=' . $order->restorant->phone . '&text=' . $message;
            return redirect()->away($url);
            // return redirect()->route('order.success', ['order' => $order]);
        } else {
            abort(404);
        }
    }

    public function cancel($ordermd)
    {

        //Find the order
        $order = Order::where('md', $ordermd)->first();
        if ($order) {
            return redirect()->route('order.cancel', ['order' => $order]);
        } else {
            abort(404);
        }
    }

    public function stripeConnect()
    {

        $application_fee_amount = 0;

        //Delivery fee
        $application_fee_amount += (int) (($this->order->delivery_price));

        //Static fee
        $application_fee_amount += (float) $this->order->static_fee;

        //Percentage fee
        $application_fee_amount += (float) $this->order->fee_value;

        //Make it for stripe
        $application_fee_amount = (int) (float) ($application_fee_amount * 100);

        //Create the charge object
        $chargeOptions = [
            'application_fee_amount' => $application_fee_amount,
            'transfer_data' => [
                'destination' => $this->vendor->user->stripe_account . '',
            ],
        ];
        return $chargeOptions;
    }

    public function paymentSuccess(Request $request, $paymentmd)
    {
        $payment = Payment::where('uuid', $paymentmd)->first();
        if ($payment) {
            $payment->paid = true;
            $payment->update();
            ConfChanger::switchCurrency($payment->restorant);
            return view('stripelinks::success', compact('payment'));
        } else {
            abort(404);
        }
    }

    public function paymentCancel($paymentmd)
    {
        $payment = Payment::where('uuid', $paymentmd)->first();
        if (!$payment) {
            abort(404);
        }

        if ((bool)$payment->paid === true) {
            $payment->paid = false;
            $payment->update();
        }

        return redirect()->route('vendor', ['alias' => $payment->restorant->getAliasAttribute()]);
    }
}
