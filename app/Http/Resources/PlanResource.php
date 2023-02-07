<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $price = money($this->price, config('global.currency'));
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $price->format(),
            'price_int' => $price->formatByDecimal(),
            'items' => (int)$this->items
        ];
    }
}
