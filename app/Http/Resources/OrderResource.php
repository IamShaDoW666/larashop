<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RestorantResource;
use Carbon\Carbon;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
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
            'total_int' => $this->total,
            'order_type' => (int)$this->order_type,
            'order_time' => $orderTime ?? null,
            'order_time_datetime' => [
                'time' => $orderTime ? $orderTime->format('g:i A') : null,
                'time_24' => $orderTime ? $orderTime->toTimeString('minute') : null,
                'date' => $orderTime ? $orderTime->toDateString() : null,
            ],
            'delivery_fee' => money($this->delivery_fee, config('global.currency'))->format(),
            'created_at' => $this->created_at,
            'ordered_at' => $this->created_at->diffForhumans(),
            'ordered_at_datetime' => [
                'time' => $this->created_at->format('g:i A'),
                'time_24' => $this->created_at->toTimeString('minute'),
                'date' => $this->created_at->toDateString(),
            ],
            'items' => ProductResource::collection($this->whenLoaded('products')),
            'restorant' => RestorantResource::make($this->whenLoaded('restorant')),
            'status_text' => $this->status_text,
            'payment_method' => $this->payment_method
        ];
    }
}
