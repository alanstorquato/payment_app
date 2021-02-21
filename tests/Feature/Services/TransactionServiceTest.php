<?php

namespace Tests\Service\Feature;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\TransactionService;
use App\Services\AuthorizeTransaction;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $transactionService;
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

        $authorizeTransaction = $this->createMock(AuthorizeTransaction::class);
        $authorizeTransaction->method('verifyAuthorizeTransaction')->willReturn(true);
        
        $this->transactionService = new TransactionService($authorizeTransaction);
    }

    public function testInsertTransactionTable()
    {
        $transaction  = $this->transactionService->transaction(200, $this->userAccount->id, $this->userStore->id);


        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertDatabaseHas(
            'transactions',
            [
                'value' => 200,
                'payer_id' => $this->userAccount->id,
                'payee_id' => $this->userStore->id
            ]
        );
    }
}
