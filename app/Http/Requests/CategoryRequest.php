<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'categoryName' => 'bail|required|max:100',
            'categoryIcon' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'categoryName.required' => 'Category name is required .',
            'categoryName.max' => 'Category name should not extend :max charachters .',
            'categoryIcon.required' => 'Category icon can not be empty .'
        ];
    }
}
