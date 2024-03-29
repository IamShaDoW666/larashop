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
            'form.customer_name' => ['required'],
            'form.customer_phone' => ['required', 'digits_between:9,17'],
            'form.address' => ['required'],
            'form.order_type' => ['required'],
            'cart' => ['']
        ];
    }

    public function messages()
    {
        return [
            'form.customer_name.required' => 'You must enter name',
            'form.customer_phone.required' => 'Invalid phone number',
            'form.customer_phone.digits_between' => 'Please enter valid phone number',
            'form.address.required' => 'Invalid address',
            'form.order_type.required' => 'Select order type',


        ];
    }
}
