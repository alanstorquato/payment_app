<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Account;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = Account::factory()->create();
    }

    public function testGetUserStatusCodeSuccess()
    {
        $response = $this->get('/api/account');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testPostUserStatusCodeSuccess()
    {
        $this->post = [
            "type" => "user",
            "document" => "01234567890",
            "balance" => 2000,
            "user_id" => $this->user->id
        ];

        $response = $this->post('/api/account', $this->post);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testInsertAccountTableTypeUser()
    {
        $user = Account::create([
            "type" => "user",
            "document" => "0124567890",
            "balance" => 2000,
            "user_id" => $this->user->id
        ]);

        $this->assertInstanceOf(Account::class, $user);
        $this->assertDatabaseHas(
            'accounts',
            [
                "type" => "user",
                "document" => "0124567890",
                "balance" => 2000,
                "user_id" => $this->user->id
            ]
        );
    }

    public function testInsertAccountTableTypeStore()
    {
        $user = Account::create([
            "type" => "store",
            "document" => "0234567890",
            "balance" => 2000,
            "user_id" => $this->user->id
        ]);

        $this->assertInstanceOf(Account::class, $user);
        $this->assertDatabaseHas(
            'accounts',
            [
                "type" => "store",
                "document" => "0234567890",
                "balance" => 2000,
                "user_id" => $this->user->id
            ]
        );
    }
}
