<?php

namespace Tests\Unit\Services;

use App\Models\Account;
use App\Models\User;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
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
            'type' => 'store',
            'document' => '73003359000196',
            'balance' => 2000,
            'user_id' => $user2->id
        ]);
  
        $this->transactionService = new TransactionService(
            $this->getMockAuthorizeTransactionSuccess(),
            new TransactionRepository(),
            new AccountRepository()
        );
    }

    public function getMockAuthorizeTransactionSuccess()
    {
        $authorizeTransaction = $this->createMock(AuthorizeTransaction::class);
        $authorizeTransaction->method('verifyAuthorizeTransaction')->willReturn(true);
        return $authorizeTransaction;
    }

    public function testPerformTransactionSuccess()
    {
        $transaction  = $this->transactionService->transaction(200, $this->userAccount, $this->userStore);
        $this->assertEquals(200, $transaction->value);
        $this->assertEquals($this->userAccount->id, $transaction->payer_id);
        $this->assertEquals($this->userStore->id, $transaction->payee_id);
    }

    public function testTransactionValues()
    {
        $this->transactionService->transaction(200, $this->userAccount, $this->userStore);
        $this->assertEquals(1800, Account::find($this->userAccount->id)->balance);
        $this->assertEquals(2200, Account::find($this->userStore->id)->balance);
    }
}
