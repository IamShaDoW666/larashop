<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateRestorantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('Owner');
    }

    //Prepare slug from name
    protected function prepareForValidation()
    {                                                                                                       
      $this->merge([                                            
        'slug' => Str::slug($this->name), //Add slug
      ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name' => ['string', 'min:4', 'max:50'],
          'phone'=> ['numeric', 'nullable', 'max:999999999999'],
          'minimum_order'=> [],
          'country'=> ['string', 'min:3', 'max:25'],
          'address'=> ['string', 'min:6', 'max:55'],
          'can_deliver'=> [],
          'can_dinein'=> [],
          'can_pickup'=> [],
          'city'=> ['string', 'min:4', 'max:30'],
          // 'postal_code' => ['numeric', 'max:100000000'],
          'slug' => ['string'],
          'currency' => ['required'],
          'banner' => [],
          'logo' => [],
          'facebook' => [''],
          'instagram' => [''],
          'twitter' => [''],
          'delivery_info' => ['']
        ];
    }
}
