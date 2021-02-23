<?php

namespace App\Http\Requests;

use App\Rules\MinBalance;
use App\Rules\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostTransactionRequest extends FormRequest
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
            'value' => ['required', 'numeric', new MinBalance($this->payer_id)],
            'payer_id' => ['required', new Store],
            'payee_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'value.numeric' => 'Value precisa ser do tipo númerico',
            'value.required' => 'Campo value requerido',
            'payer_id.required' => 'Campo payer_id requerido',
            'payee_id.required' => 'Campo payee_id requerido',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['error' => $validator->errors()], 405));
    }
}
