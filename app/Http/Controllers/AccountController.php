<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PostAccountRequest;
use App\Repositories\AccountRepository;

class AccountController extends Controller
{
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        return response()->json(
            $this->accountRepository->all(),
            Response::HTTP_OK
        ); 
    }

    public function store (PostAccountRequest $request)
    {   
        return response()->json( 
            $this->accountRepository->create($request->all()), 
            Response::HTTP_CREATED
        );

    }

}
