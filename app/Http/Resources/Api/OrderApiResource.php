<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total = +$this->total - +$this->delivery_fee;
        $orderTime = Carbon::make($this->order_time);
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'status' => $this->status,
            'address' => $this->address,
            'tax' => money($this->tax, config('global.currency'))->format(),
            'tax_name' => $this->tax_name,
            'tax_percent' => $this->tax_percent,
            'subtotal' => money($this->subtotal, config('global.currency'))->format(),
            'total' => money($this->total, config('global.currency'))->format(),
            'total_int' => +$this->total,
            'delivery_fee' => money($this->delivery_fee, config('global.currency'))->format(),
            'delivery_fee_int' => +$this->delivery_fee,
            'order_type' => (int)$this->order_type,
            'order_time' => Carbon::make($this->order_time),
            'order_time_datetime' => [
                'time' => $orderTime ? $orderTime->format('g:i A') : null,
                'time_24' => $orderTime ? $orderTime->toTimeString('minute') : null,
                'date' => $orderTime ? $orderTime->toDateString() : null,
            ],
            'created_at' => $this->created_at,
            'ordered_at' => $this->created_at->diffForhumans(),
            'items' => ProductApiResource::collection($this->whenLoaded('products')),
            'restorant' => RestorantApiResource::make($this->whenLoaded('restorant'))
        ];
    }
}
