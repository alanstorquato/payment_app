<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function index(){
        return response()->json(
            Transaction::query()->orderBy('document')->get(),
            Response::HTTP_OK
        ); 
    }

    public function create (Request $request)
    {   
        return response()->json( 
            Transaction::create($request->all()), 
            Response::HTTP_CREATED
        );

    }
}
