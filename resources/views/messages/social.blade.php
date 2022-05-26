<?php

$nl = "\n\n";
$tabSpace = "      ";

function set($value)
{
    return $value && isset($value) ? $value : "";
}

$currency = config('global.currency');

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
    $lineprice = $item->pivot->quantity . ' X ' . $item->name . " - " . money($item->pivot->quantity * $item->price, $currency)->format();
    // if (strlen($item->pivot->variant_name) > 3) {
    //     $lineprice .= $nl . $tabSpace . __('Variant:') . " " . $item->pivot->variant_name;
    // }
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
{{ "*". __('Delivery Fee')."*".": ". set(money($order->delivery_fee, $currency)->format())}}
{{ "*". __('Subtotal')."*".": ". set(money($order->total, $currency)->format())}}
{{"*". __('Phone')."*.: ". set($order->customer_phone) }}
{{ "*". __('Address')."*".": ". set($order->address)}}

{{ config('app.url') . '/restorants/'. $order->restorant->slug }}