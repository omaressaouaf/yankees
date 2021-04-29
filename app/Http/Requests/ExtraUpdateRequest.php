<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtraUpdateRequest extends FormRequest
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
            'name' =>  'required|unique:extras,name,' . $this->extra->id,
            "label"=> 'required',
            'title' => 'required',
            'newOptions' => 'nullable|array',
            'newOptions.*.name' => 'required',
            'newOptions.*.price' => 'required|integer|min:0',
        ];
    }
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->newOptions) && empty($this->options)) {
                $validator->errors()->add('options', 'The options field is required');
            }
        });
    }
}
