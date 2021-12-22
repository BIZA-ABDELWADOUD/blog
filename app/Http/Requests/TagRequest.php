<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'tagName' => 'bail|required|unique:tags,tagName,'.$this->id.',id|max:100'
        ];
    }

    public function messages()
    {
        return [
            'tagName.required' => 'Tag Name can not be empty.',
            'tagName.unique' => 'This Tag existe in the database.',
            'tagName.max' => 'You can not add more than :max charachters.',
        ];
    }
}
