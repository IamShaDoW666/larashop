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
    $price_int = $price->formatByDecimal();
    $pivot_qty = $this->whenPivotLoaded('order_product', $this->pivot ? $this->pivot->quantity : null);

    $variant_price_int = $this->whenPivotLoaded('order_product', function () {
      return (int)money($this->pivot ? $this->pivot->variant_price : null, config('global.currency'))->getAmount();
    });

    $variant_price_formatted = $this->whenPivotLoaded('order_product', function () {
      return money($this->pivot ? $this->pivot->variant_price : null, config('global.currency'))->format();
    });

    $subtotalFormatted = null;
    $subtotal = null;
    if ($pivot_qty && $pivot_qty != null) {
      if ($variant_price_int) {
        $subtotal = $variant_price_int * $pivot_qty;
      } else {
        $subtotal = $price_int * $pivot_qty;
      }
      $subtotalFormatted = money($subtotal, config('global.currency'));
    }
    return [
      'id' => $this->id,
      'name' => $this->name,
      'description' => ($this->description) . '...',
      'price' => $price->format(),
      'price_int' => $price_int,
      'subtotal' => $subtotal ?? null,
      'subtotal_formatted' => $subtotalFormatted ? $subtotalFormatted->format() : null,
      'category_id' => $this->category_id,
      'image' => $this->image,
      'image_path' => $this->image_path,
      'imglarge' => $this->imglarge,
      'quantity' => null, //quantity for show.vue 
      'variants' => VariantResource::collection($this->whenLoaded('variants')),
      'pivot_quantity' => $this->whenPivotLoaded('order_product', $this->pivot ? $this->pivot->quantity : null), //quantity from order
      'variant_name' => $this->whenPivotLoaded('order_product', $this->pivot ? $this->pivot->variant_name : null), //quantity from order
      'variant_price_formatted' => $variant_price_formatted ?? null,
      'variant_price_int' => $variant_price_int ?? null,
      'variant_id' => $this->whenPivotLoaded('order_product', $this->pivot ? $this->pivot->variant_id : null) //quantity from order
    ];
  }
}
