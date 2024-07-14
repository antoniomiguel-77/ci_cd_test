<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        try {
           $credential = ["email"=>$request->email,"password"=>$request->password];

       
           if (Auth::attempt($credential)) {
            //generate token 
            if (Auth::check()) {
                // $token = $request->user()->createToken("Test");
                return response([
                    "message"=>"User Authenticared successfully",
                    "token"=>auth()->user()
                ],200);
            }

           }
        } catch (\Throwable $th) {
            return response()->json(["error"=>$th->getMessage()],400);

        }
    }

    public function logout()
    {
        try {
         Auth::logout();
         return response([
            "message"=>"User Logout successfully",
        ],200);
        } catch (\Throwable $th) {
            return response()->json(["error"=>$th->getMessage()],400);

        }
    }
}
