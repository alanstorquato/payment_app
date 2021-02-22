<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizeTransaction
{
    public function verifyAuthorizeTransaction(): bool
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6')->json();

        if ($response['message'] == "Autorizado") {
            return true;
        }

        throw new \Exception('Transação não autorizada');
    }
}
