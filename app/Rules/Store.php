<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\AccountRepository;

class Store implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $account = (new AccountRepository())->find($value);
        return $account->type === 'user';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Lojista não pode realizar transferencia';
    }
}
