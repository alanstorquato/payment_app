<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository
{
    public function all(): Collection
    {
        return Account::all();    
    }

    public function create(array $data): Account
    {
        return Account::create($data);
    }

}
