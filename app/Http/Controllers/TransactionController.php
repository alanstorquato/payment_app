<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostTransactionRequest;
use App\Repositories\AccountRepository;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    protected $transactionRepository;
    protected $accountRepository;

    public function __construct(TransactionRepository $transactionRepository, AccountRepository $accountRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->accountRepository = $accountRepository;

    }

    public function index()
    {
        return response()->json(
            $this->transactionRepository->all(),
            Response::HTTP_OK
        ); 
    }

    public function store (PostTransactionRequest $request, TransactionService $transactionService)
    {   
        try {
            $transction = $transactionService->transaction(
                $request->value,
                $this->accountRepository->find($request->payer_id),
                $this->accountRepository->find($request->payee_id) 
            );
            
        }catch(\Exception $e){
            return response()->json( 
                ['error' => $e->getMessage()], 
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }
  
        return response()->json( 
            [$transction], 
            Response::HTTP_CREATED
        );

    }
}
