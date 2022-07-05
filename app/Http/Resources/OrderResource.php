<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RestorantResource;

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
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'status' => $this->status,
            'address' => $this->address,
            'total' => money($this->total, config('global.currency'))->format(),
            'total_int' => $this->total,
            'order_type' => (int)$this->order_type,
            'delivery_fee' => money($this->delivery_fee, config('global.currency'))->format(),
            'created_at' => $this->created_at,
            'ordered_at' => $this->created_at->diffForhumans(),
            'ordered_at_datetime' => [
                'time' => $this->created_at->format('g:i A'),
                'time_24' => $this->created_at->toTimeString('minute'),
                'date' => $this->created_at->toDateString(),
            ],
            'items' => ProductResource::collection($this->whenLoaded('products')),
            'restorant' => RestorantResource::make($this->whenLoaded('restorant'))
        ];
    }
}
