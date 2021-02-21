<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index(){
        return response()->json(
            Transaction::all(),
            Response::HTTP_OK
        ); 
    }

    public function store (Request $request, TransactionService $transactionService)
    {   
        try {

            $transction = $transactionService->transaction(
                $request->value,
                $request->payer_id, 
                $request->payee_id
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
