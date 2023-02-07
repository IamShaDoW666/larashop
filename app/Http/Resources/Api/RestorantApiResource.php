<?php

namespace App\Http\Resources\Api;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\CategoryResource;

class groceryApiResource extends JsonResource
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
            'phone' => $this->phone,
            'country' => $this->country,
            'address' => $this->address,
            'city' => $this->city,
            'url' => config('app.url') . '/grocerys/' . $this->slug,
            'postal_code' => $this->postal_code,
            'products' => ProductApiResource::collection($this->whenLoaded('products')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'orders' => OrderApiResource::collection($this->whenLoaded('orders')),
            'config' => $this->whenLoaded('config'),
            'counts' => $this->whenAppended('counts'),
            'salesCount' => $this->whenAppended('salesCount'),
            'lat' => $this->lat,
            'lng' => $this->lng,
            'open_msg' => $this->openStatus ?? null,
            'open_status' => '' ,
            'banner' => config('app.url') . $this->banner,
            'logo' => config('app.url') . $this->logo
        ];
    }
}
