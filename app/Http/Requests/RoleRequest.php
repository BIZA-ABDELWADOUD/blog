<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'roleName' => 'bail|required|unique:roles,roleName,'.$this->id.',id|max:100'
        ];
    }

    public function messages() 
    {
        return [
           'roleName.required' => 'The role name is required',
           'roleName.unique' => 'Role exist already in the database',
           'roleName.max' => 'Role name can not contain more than :max charachters' 
        ];
    }
}
