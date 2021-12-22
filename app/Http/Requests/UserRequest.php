<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'FullName' => 'bail|required|max:60',
            'email' => 'bail|required|unique:users,email,'.$this->id.',id',
            'password' => 'bail|required_with:'.$this->id,'|min:6|max:150',
            'role_id' => 'bail|required'
        ];
    }

    public function messages() 
    {
        return [
            // name
            'FullName.required' => "User Name can not be empty.",
            'FullName.max' => "Name should not contain more than :max charachters.",
            // email
            'email.required' => 'The email is required.',
            'email.email' => 'Email form is incorrect.',
            'email.unique' => 'Email already existe in the database',
            // password
            'password.required' => 'Password can not be empty.',
            'password.min' => 'Password should contain at least :min charachters.',
            'password.max' => 'Password should not contain more than :max charachters.',
            // userType
            'role_id.required' => 'You should select user type.',

        ];

    }
}
