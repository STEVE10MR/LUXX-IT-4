<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveFormUser extends FormRequest
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
            'nombres'=>'required|max:45',
            'apellidos'=>'required|max:45',
            'email'=>'required|max:120',
            'numero'=>'required|max:9',
            'password'=>'required|max:20',
            'password_r'=>'required|max:20',
        ];
    }
}
