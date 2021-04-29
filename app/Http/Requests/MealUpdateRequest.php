<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealUpdateRequest extends FormRequest
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
            'title' => 'required',
            'desc' => 'nullable',
            'newImage' => 'nullable|image',
            'price' => 'required|integer|min:0',
            'active' => 'required|boolean',
            'category_id' => 'required',
            'extras' => 'nullable|array',
            'extras.*.pivot.admin_selected_options' => 'required|array',
            'extras.*.pivot.min' => 'required|integer|min:0',
            'extras.*.pivot.max' => 'required|integer|min:1|gte:extras.*.pivot.min',

        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach ($this->extras as $extra) {
                if (count($extra['pivot']['admin_selected_options']) < $extra['pivot']['min'] || count($extra['pivot']['admin_selected_options']) < $extra['pivot']['max']) {
                    $validator->errors()->add($extra['name'], $extra['name'].' selected options should respect the min and the max limits');
                }
            }
        });
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'active' => filter_var($this->active, FILTER_VALIDATE_BOOLEAN),
            'extras'=>json_decode($this->extras , true),
            'desc'=> $this->desc==null ? '' : $this->desc
        ]);
    }

}
