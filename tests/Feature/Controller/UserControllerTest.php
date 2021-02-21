<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUserStatusCodeSuccess()
    {
        $response = $this->get('/api/user');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testPostUserStatusCodeSuccess()
    {
        $this->post = [
            "name" => "usuario 2",
            "email" => "user2@teste.com",
            "password" => "123"
        ];

        $response = $this->post('/api/user', $this->post);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testInsertUserTable()
    {
        $user = User::create([
            'name' => 'Teste 1',
            'email' => 'user1@teste.com',
            'password' =>  '123',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas(
            'users',
            [
                'name' => 'Teste 1',
                'email' => 'user1@teste.com',
                'password' =>  '123',
            ]
        );
    }

}
