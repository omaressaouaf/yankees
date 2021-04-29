<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtraStoreRequest extends FormRequest
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

            'name' => 'required|unique:extras',
            "label"=> 'required',
            'title' => 'required',
            'newOptions' => 'required|array',
            'newOptions.*.name' => 'required',
            'newOptions.*.price' => 'required|integer|min:0',
        ];
    }

}
