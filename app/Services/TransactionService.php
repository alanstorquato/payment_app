<?php

namespace App\Services;

use App\Jobs\TransactionMadeMessage;
use App\Models\{Account, Transaction};

use App\Services\AuthorizeTransaction;

use Illuminate\Support\Facades\DB;

class TransactionService
{

    protected $authorizeTransaction;

    public function __construct(AuthorizeTransaction $authorizeTransaction)
    {
        $this->authorizeTransaction = $authorizeTransaction;
    }

    public function transaction($value, $payerId, $payeeId)
    {
        $payer = Account::find($payerId);
        $payee = Account::find($payeeId);

        if ($payer->type === 'store') {
            throw new \Exception('Lojista não pode realizar transferencia');
        }

        if ($payer->balance >= $value) {
            $payer->balance = $payer->balance - $value;
            $payee->balance = $payee->balance + $value;

            $transaction =  Transaction::create([
                    'value' => $value,
                    'payer_id' => $payer->id,
                    'payee_id' => $payee->id,
            ]);

            if ($this->authorizeTransaction->verifyAuthorizeTransaction()) {
        
                DB::transaction(function () use ($transaction, $payer, $payee){
                    $transaction->authorized = true;
                    $transaction->save();
                    $payer->save();
                    $payee->save();
                }, 2);
      
           
                TransactionMadeMessage::dispatch();
                
            }
            return $transaction;
        }

        throw new \Exception('Valor da transferencia maior que saldo do pagador');
    }
}
