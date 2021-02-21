<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthorizeTransactionTest extends TestCase
{
    protected $testMessage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorized = new AuthorizeTransaction();

    }
    public function testAuthorizeTransactionSuccess()
    {
        $response = $this->authorized->verifyAuthorizeTransaction();
        $this->assertNotFalse($response);
    }

}