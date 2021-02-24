<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/api/user",
     *     description="Returns a Collection of Users",
     *     @OA\Response(response="200", description="A list with users"),
     * ),
     *
    */
    public function index(): JsonResponse
    {
        return response()->json(
            $this->userRepository->all(),
            Response::HTTP_OK
        );
    }

    /**
    * @OA\Post(
    *   tags={"Users"},
    *   path="/api/user",
    *   description="Create a Users",
    *   @OA\RequestBody(
    *       @OA\MediaType(mediaType="application/json",
    *           @OA\Schema(
    *               @OA\Property(property="name", type="string"),
    *               @OA\Property(property="email", type="string"),
    *               @OA\Property(property="password", type="string"),
    *               required={"type", "name", "email", "password"}
    *           )
    *       )
    *   ),
    *   @OA\Response(response="201", description="user created")
    * )
    */
    public function store(PostUserRequest $request): JsonResponse
    {
        return response()->json(
            $this->userRepository->create($request->all()),
            Response::HTTP_CREATED
        );
    }
}
