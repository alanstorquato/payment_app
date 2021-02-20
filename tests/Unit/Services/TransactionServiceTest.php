<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\TransactionService;
use Exception;
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

        $this->transactionService = new TransactionService();
    }

    public function testPerformTransactionSuccess()
    {
        $transaction  = $this->transactionService->transaction(200, $this->userAccount->id, $this->userStore->id);
        $this->assertEquals(200, $transaction->value);
        $this->assertEquals($this->userAccount->id, $transaction->payer_id);
        $this->assertEquals($this->userStore->id, $transaction->payee_id);
        $this->assertEquals(1800, Account::find($this->userAccount->id)->balance);
        $this->assertEquals(2200, Account::find($this->userStore->id)->balance);
    }

    public function testPerformTransactionFail() {
      
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Valor da transferencia maior que saldo do pagador');

        $this->transactionService->transaction(3000, $this->userAccount->id, $this->userStore->id);

    }

    public function testPerformTransactionStore() {
      
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Lojista não pode realizar transferencia');

        $this->transactionService->transaction(3000, $this->userStore->id, $this->userAccount->id);

    }
}
