<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PostAccountRequest;
use App\Repositories\AccountRepository;

class AccountController extends Controller
{
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

      /**
     * @OA\Get(
     *     tags={"accounts"},
     *     summary="Returns a list of accounts",
     *     description="Returns a object of accounts",
     *     path="/api/account",
     *     @OA\Response(response="200", description="A list with accounts"),
     * ),
     * 
    */
    public function index()
    {
        return response()->json(
            $this->accountRepository->all(),
            Response::HTTP_OK
        );
    }

    public function store(PostAccountRequest $request)
    {
        return response()->json(
            $this->accountRepository->create($request->all()),
            Response::HTTP_CREATED
        );
    }
}
