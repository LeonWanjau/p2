<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUser extends FormRequest
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
            'f_name' => 'min:3|required',
            'l_name' => 'min:3|required',
            'email' => 'email|required',
            'phone_number'=>'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'f_name.required' => 'The first name must be at least 3 characters',
            'f_name.min'=>'The first name must be at least 3 characters',
            'l_name.required' => 'The last name must be at least 3 characters',
            'l_name.min'=>'The last name must be at least 3 characters',

        ];
    }
}
