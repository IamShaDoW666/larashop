<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => money($this->price, config('global.currency'))->format(),
            'price_int' => money($this->price, config('global.currency'))->formatByDecimal()
        ];
    }
}
