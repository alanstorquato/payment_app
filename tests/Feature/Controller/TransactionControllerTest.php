<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\TransactionService;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{

    public function testTransactionStatusCodeSuccess()
    {
        $response = $this->get('/api/transaction');

        $response->assertStatus(Response::HTTP_OK);
    }


}
