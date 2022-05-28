<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

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
            'address' => $this->address,
            'total' => money($this->total, config('global.currency'))->format(),
            'total_int' => $this->total,
            'order_type' => $this->order_type,
            'delivery_fee' => money($this->delivery_fee, config('global.currency'))->format(),
            'created_at' => $this->created_at->diffForHumans(),
            'items' => ProductResource::collection($this->whenLoaded('products'))
        ];
    }
}
