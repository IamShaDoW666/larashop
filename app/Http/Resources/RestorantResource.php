<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class RestorantResource extends JsonResource
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
            'id' => Crypt::encrypt($this->id),
            'name' => $this->name,
            'slug' => $this->slug,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'config' => $this->whenLoaded('config'),
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }
}
