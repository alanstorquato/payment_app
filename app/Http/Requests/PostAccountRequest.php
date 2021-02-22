<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostAccountRequest extends FormRequest
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
            'type' => 'required',
            'document' => 'required|unique:accounts|min:11|max:14',
            'balance' => 'required|numeric',
            'user_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Campo type requerido',
            'document.required' => 'Campo document requerido',
            'document.min' => 'Campo document deve conter no minimo 11 digitos',
            'document.max' => 'Campo document deve conter no maximo 14 digitos',
            'document.unique' => 'Conta já foi registrada',
            'balance.required' => 'Campo balance requerido',
            'balance.numeric' => 'balance precisa ser do tipo númerico',
            'user_id.required' => 'Campo user_id requerido',
        ];
    }
}
