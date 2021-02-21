<?php

namespace App\Services;

use GuzzleHttp\RetryMiddleware;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SendAuthorizeTransactionMessageTest extends TestCase
{
    protected $testMessage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testMessage = new SendAuthorizeTransactionMessage();

    }
    public function testSendMessageSuccess()
    {
        $response = $this->testMessage->sendMessage();
        $this->assertEquals($response, ['message' => 'Enviado']);
    }

}