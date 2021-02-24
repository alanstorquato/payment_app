<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Account;
use App\Models\User;
use Tests\TestCase;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

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
    }

    public function testGetTransactionStatusCodeSuccess()
    {
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

        $response = $this->post('/api/transaction', $this->post);

        $response->assertStatus(Response::HTTP_CREATED);
    }


    public function testPostUserBalanceLessTransaction()
    {
        $this->userAccount->balance = 2000;
        $this->userAccount->save();
        $this->post = [
            'value' => 3000,
            'payer_id' => $this->userAccount->id,
            'payee_id' => $this->userStore->id
        ];
        
        $response = $this->post('/api/transaction', $this->post);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testPostStoreCanNotExecuteTransaction()
    {
        $this->userStore->type = 'store';
        $this->userStore->save();

        $this->post = [
            'value' => 200,
            'payer_id' => $this->userStore->id,
            'payee_id' => $this->userAccount->id
        ];

        $response = $this->post('/api/transaction', $this->post);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
