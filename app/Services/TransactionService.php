<?php

namespace App\Services;

use App\Models\{Account, Transaction};
use Exception;

use function PHPUnit\Framework\throwException;

class TransactionService
{
    public function transaction($value, $payerId, $payeeId)
    {

        $payer = Account::find($payerId);
        $payee = Account::find($payeeId);

        if($payer->balance >= $value){

            $payer->balance = $payer->balance - $value;
            $payee->balance = $payee->balance + $value;

            $payer->save();
            $payee->save();

            return Transaction::create(
                [
                   'value' => $value, 
                   'payer_id' => $payer->id, 
                   'payee_id' => $payee->id
                ]
                
            );

        }
        
        throw new Exception('Valor da transferencia maior que saldo do pagador');

    }
}
