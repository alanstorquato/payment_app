<?php

namespace Tests\Service\Feature;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\TransactionService;
use App\Services\AuthorizeTransaction;
use App\Repositories\TransactionRepository;

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

        $this->userAccount = Account::factory()->create();
        $this->userAccount->type = 'user';
        $this->userAccount->save();
        
        $this->userStore =  Account::factory()->create();
        $this->userStore->type = 'store';
        $this->userStore->save();
  
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

    public function testInsertTransactionTable()
    {
        $transaction  = $this->transactionService->transaction(200, $this->userAccount, $this->userStore);


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
