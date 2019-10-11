<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearch extends FormRequest
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
            'search_column'=>'present',
            'search_value'=>'required'
        ];
    }

    public function messages(){
        return [
            'search_column.present'=>'Enter a Column',
            'search_value.required'=>'Enter a Value'
        ];
    }
}
