<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\AccountRepository;

class MinBalance implements Rule
{
    protected $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $account = (new AccountRepository())->find($this->data);
        return $account->balance >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Valor da transferencia maior que saldo do pagador';
    }
}
