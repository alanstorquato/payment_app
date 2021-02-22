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

    /**
     * @OA\Get(
     *     tags={"Transactions"},
     *     path="/api/transaction",
     *     description="Returns a Collection of Transactions",
     *     @OA\Response(response="200", description="A list with transactions"),
     * ),
     *
    */
    public function index()
    {
        return response()->json(
            $this->transactionRepository->all(),
            Response::HTTP_OK
        );
    }

    /**
    * @OA\Post(
    *   tags={"Transactions"},
    *   path="/api/transaction",
    *   description="Create a Transactions",
    *   @OA\RequestBody(
    *       @OA\MediaType(mediaType="application/json",
    *           @OA\Schema(
    *               @OA\Property(property="value", type="number"),
    *               @OA\Property(property="payer_id", type="integer"),
    *               @OA\Property(property="payee_id", type="integer"),
    *               required={"value", "payer_id", "payee_id"}
    *           )
    *       )
    *   ),
    *   @OA\Response(response="201", description="transactions created"),
    *   @OA\Response(response="405", description="transactions not allowed")
    * )
    */
    public function store(PostTransactionRequest $request, TransactionService $transactionService)
    {
        try {
            $transction = $transactionService->transaction(
                $request->value,
                $this->accountRepository->find($request->payer_id),
                $this->accountRepository->find($request->payee_id)
            );
        } catch (\Exception $e) {
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
