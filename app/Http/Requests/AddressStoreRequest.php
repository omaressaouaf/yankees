<?php

namespace App\Http\Requests;

use App\Models\Address;
use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'line'=> 'required',
            'details'=> 'required',
            'latitude'=> 'required|numeric',
            'longitude'=> 'required|numeric'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if(!Address::inBounds($this->latitude , $this->longitude)) {
                $validator->errors()->add('address', 'out of the delivery zone');
            }
        });
    }

}
