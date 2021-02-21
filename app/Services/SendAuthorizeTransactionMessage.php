<?php

namespace App\Services;

use GuzzleHttp\RetryMiddleware;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class SendAuthorizeTransactionMessage
{
    public function sendMessage()
    {
        $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        
        if($response->status() == Response::HTTP_OK) {
            return $response->json();
        }

        throw new \Exception('Erro ao enviar mensagem');
    }

}