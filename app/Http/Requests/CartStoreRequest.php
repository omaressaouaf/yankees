<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
            'id' => 'required',
            'qty' => 'required|integer|min:1|max:20',
            'price'=> 'required|integer|min:0',
            "extras" => 'nullable|array'
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($this->extras as $extra) {
                if (count($extra['user_selected_options']) < $extra['pivot']['min'] || count($extra['user_selected_options']) > $extra['pivot']['max']) {
                    $validator->errors()->add($extra['id'], 'The selected options should respect the min and the max limits');
                }
            }
        });
    }
}
