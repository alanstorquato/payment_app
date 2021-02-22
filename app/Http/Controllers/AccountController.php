<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PostAccountRequest;

class AccountController extends Controller
{
    public function index(){
        return response()->json(
            Account::query()->orderBy('document')->get(),
            Response::HTTP_OK
        ); 
    }

    public function store (PostAccountRequest $request)
    {   
        return response()->json( 
            Account::create($request->all()), 
            Response::HTTP_CREATED
        );

    }

}
