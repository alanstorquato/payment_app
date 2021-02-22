<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function all(): Collection
    {
        return User::all();    
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

}
