<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccount extends FormRequest
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
            
         'first_name'=>'min:3|required',
         'last_name'=>'min:3|required',
         'email'=>'required|email|unique:users',
         'phone_number'=>'required|numeric',
         'password'=>'required|min:6',
         'role'=>'present'
         
        ];
        
    }
}
