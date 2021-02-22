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
     *     tags={"Accoounts"},
     *     path="/api/account",
     *     description="Returns a Collection of Accounts",
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

    /**
    * @OA\Post(
    *   tags={"Accoounts"},
    *   path="/api/account",
    *   description="Create a Account",
    *   @OA\RequestBody(
    *       @OA\MediaType(mediaType="application/json",
    *           @OA\Schema(
    *               @OA\Property(property="type", type="string"),
    *               @OA\Property(property="document", type="string"),
    *               @OA\Property(property="balance", type="number"),
    *               @OA\Property(property="user_id", type="integer"),
    *               required={"type", "document", "balance", "user_id"}
    *           )
    *       )
    *   ),
    *   @OA\Response(response="201", description="account created")
    * )
    */
    public function store(PostAccountRequest $request)
    {
        return response()->json(
            $this->accountRepository->create($request->all()),
            Response::HTTP_CREATED
        );
    }
}
