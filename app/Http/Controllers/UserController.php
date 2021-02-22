<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return response()->json(
            $this->userRepository->all(),
            Response::HTTP_OK
        ); 
    }

    public function store (PostUserRequest $request)
    {   
        return response()->json(
            $this->userRepository->create($request->all()),
            Response::HTTP_CREATED
        );

    }
}
