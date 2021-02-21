<?php

namespace Tests\Feature\Controller;

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
    use RefreshDatabase;

    protected $userAccount;
    protected $userStore;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::create([
            'name' => 'Teste 1',
            'email' => 'user1@teste.com',
            'password' =>  '123',
        ]);

        $user2 = User::create([
            'name' => 'Teste 1',
            'email' => 'user2@teste.com',
            'password' =>  '123',
        ]);

        $this->userAccount =  Account::create([
            'type' => 'user',
            'document' => '01234567890',
            'balance' => 2000,
            'user_id' => $user->id
        ]);

        $this->userStore =  Account::create([
            'type' => 'user',
            'document' => '01234567890',
            'balance' => 2000,
            'user_id' => $user2->id
        ]);
    }

    public function testGetTransactionStatusCodeSuccess()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/transaction');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testPostTransactionStatusCodeSuccess()
    {
        $this->post = [
            'value' => 200,
            'payer_id' => $this->userAccount->id,
            'payee_id' => $this->userStore->id
        ];

        $this->withoutExceptionHandling();

        $response = $this->post('/api/transaction', $this->post);

        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function testPostTransactionStatusCodeNotAllowed()
    {
        $this->post = [
            'value' => 3000,
            'payer_id' => $this->userAccount->id,
            'payee_id' => $this->userStore->id
        ];

        $this->withoutExceptionHandling();

        $response = $this->post('/api/transaction', $this->post);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }


}