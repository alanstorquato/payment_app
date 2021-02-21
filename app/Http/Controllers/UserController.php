<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(){
        return response()->json(
            User::query()->orderBy('name')->get(),
            Response::HTTP_OK
        ); 
    }

    public function store (Request $request)
    {   
        return response()->json( 
            User::create($request->all()), 
            Response::HTTP_CREATED
        );

    }
}
