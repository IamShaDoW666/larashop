<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Cknow\Money\Money;
use Cknow\Money\Currency;

class ProductResource extends JsonResource
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
      'description' =>  ($this->description), 0, 20 . '...',
      'price' => $price->format(),
      'price_int' => $price->formatByDecimal(),
      'category_id' => $this->category_id,
      'image' => $this->image,
      'imglarge' => $this->imglarge,
      'quantity' => null
    ];
  }
}
