<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => [''],
            'customer_phone' => '',
            'address' => ['required'],
            'order_type' => ['required'],
            'restorant_id' => ['required'],
            'delivery_fee' => ['']
        ];
    }
}
