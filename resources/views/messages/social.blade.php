<?php

$nl = "\n\n";
$tabSpace = "      ";

function set($value)
{
    return $value && isset($value) ? $value : "";
}

$currency = config('global.currency');

?>
*************************************** {{ "\n" }}
@if($order->order_type==1)
{{ "Delivery order from " . set($order->customer_name) . "👇" }}
@endif
@if($order->order_type==2)
{{ "Pickup order from " . set($order->customer_name) . "👇" }}
@endif
@if($order->order_type==3)
{{ "Dine-in order from " . set($order->customer_name) . "👇" }}
@endif
{{"*". __('Phone')."*.: ". set($order->customer_phone) }}
{{ "*". __('Address')."*".": ". set($order->address)}}
{{ "*". __('Delivery Fee')."*".": ". set(money($order->delivery_fee, $currency)->format())}}
{{ "*". __('Subtotal')."*".": ". set(money($order->total, $currency)->format())}}