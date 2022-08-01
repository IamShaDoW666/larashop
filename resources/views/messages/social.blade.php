<?php
use Illuminate\Support\Carbon;

$nl = "\n\n";
$tabSpace = "      ";
function set($value)
{
    return $value && isset($value) ? $value : "";
}

$currency = config('global.currency');
$orderTimeDate = Carbon::make($order->order_time) ? Carbon::make($order->order_time)->toDateString() : '';
$orderTimeFormat = Carbon::make($order->order_time) ? Carbon::make($order->order_time)->format('g:i A') : '';
?>
@if($order->order_type==1)
{{ "Delivery order from " . set($order->customer_name) . "👇" }}
@endif
@if($order->order_type==2)
{{ "Pickup order from " . set($order->customer_name) . "👇" }}
@endif
@if($order->order_type==3)
{{ "Dine-in order from " . set($order->customer_name) . "👇" }}
@endif

{{"*". __('ORDERED ITEMS')."*".":"}}
<?php
foreach ($order->products()->get() as $key => $item) {
    $item_name = $item->name;
    if (strlen($item->pivot->variant_name)) {
        $item_name = $item->name . ' ' . $item->pivot->variant_name;
    }
    $lineprice = $item->pivot->quantity . ' X ' . $item_name . " - " . money($item->pivot->quantity * (int)$item->pivot->variant_price, $currency)->format();  
    // if (strlen($item->pivot->extras) > 3) {
    //     foreach (json_decode($item->pivot->extras) as $key => $extra) {
    //         $lineprice .= $nl . $tabSpace . $extra;
    //     }
    // }

?>
    🔘{{ $lineprice }}
<?php
}
?>
*************************************** {{ "\n" }}
@if ($order->delivery_fee)
{{ "*". __('Delivery Fee')."*".": ". set(money($order->delivery_fee, $currency)->format())}}
@endif
{{ "*". __('Subtotal')."*".": ". set(money($order->total, $currency)->format())}}
{{"*". __('Phone')."*.: ". set($order->customer_phone) }}
{{ "*". __('Address')."*".": ". set($order->address)}}
{{ "*". __('Date')."*".": ". set($orderTimeDate)}}
{{ "*". __('Time')."*".": ". set($orderTimeFormat)}}

{{ "*Order No*: " . $order->id}}
{{ __('Track your Order') }}
{{ config('app.url') . '/order/status/' . $order->id }}