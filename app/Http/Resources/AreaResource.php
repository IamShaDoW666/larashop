<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $delivery_fee = money($this->delivery_fee, config('global.currency'));
        return [
          'id' => $this->id,
          'name' => $this->name,
          'delivery_fee' => $delivery_fee->format(),
          'delivery_fee_int' => $delivery_fee->formatByDecimal()
        ];
    }
}
