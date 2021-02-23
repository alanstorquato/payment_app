<?php

namespace App\Services;

use App\Jobs\TransactionMadeMessage;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use App\Services\AuthorizeTransaction;

use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected $authorizeTransaction;
    protected $transactionRepository;
    protected $accountRepository;

    public function __construct(
        AuthorizeTransaction $authorizeTransaction,
        TransactionRepository $transactionRepository,
        AccountRepository $accountRepository
    ) {
        $this->authorizeTransaction = $authorizeTransaction;
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;
    }

    public function transaction($value, Account $payer, Account $payee)
    {
        $this->validateTransaction($payer, $value);

        $payer->setAttribute('balance', $payer->balance - $value);
        $payee->setAttribute('balance', $payee->balance + $value);
        
        $transaction = $this->transactionRepository->create([
            'value' => $value,
            'payer_id' => $payer->id,
            'payee_id' => $payee->id,
        ]);
        
        if ($this->authorizeTransaction->verifyAuthorizeTransaction()) {
            DB::transaction(function () use ($transaction, $payer, $payee) {
                $this->transactionRepository->update(['authorized' => true], $transaction->id);
                $this->accountRepository->update(['balance' => $payer->balance], $payer->id);
                $this->accountRepository->update(['balance' => $payee->balance], $payee->id);
            }, 2);
      
            TransactionMadeMessage::dispatch();
        }

        return $transaction;
    }

    private function validateTransaction($payer, $value)
    {
        if ($payer->type === 'store') {
            throw new \Exception('Lojista não pode realizar transferencia');
        }

        if ($payer->balance < $value) {
            throw new \Exception('Valor da transferencia maior que saldo do pagador');
        }
    }
}
