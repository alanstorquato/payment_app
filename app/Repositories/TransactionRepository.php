<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    public function all(): Collection
    {
        return Transaction::all();
    }

    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function update(array $data, $id)
    {
        return Transaction::find($id)->update($data);
    }
}
