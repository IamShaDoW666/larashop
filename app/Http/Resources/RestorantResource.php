<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
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
            'phone' => $this->phone,
            'country' => $this->country,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'config' => $this->whenLoaded('config'),
            'counts' => $this->whenAppended('counts'),
            'salesCount' => $this->whenAppended('salesCount'),
            'todaySales' => $this->whenAppended('todaySales'),
            'yesterdaySales' => $this->whenAppended('yesterdaySales'),
            'lat' => $this->lat,
            'lng' => $this->lng,
            'open_msg' => $this->openStatus['openMsg'] ?? null,
            'open_status' => $this->openStatus['openStatus'] ?? null ,
            'banner' => $this->banner,
            'logo' => $this->logo,
            'instagram' => $this->instagram,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
        ];
    }
}
