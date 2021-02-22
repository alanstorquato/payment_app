<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Campo name requerido',
            'email.required' => 'Campo email requerido',
            'email.unique' => 'email já foi registrada',
            'email.email' => 'valor fornecido não é um e-mail',
            'password.required' => 'Campo password requerido',
        ];
    }
}
