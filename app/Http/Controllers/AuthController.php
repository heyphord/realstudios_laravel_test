<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class AuthController extends Controller
{
    
     //Administrator login
    public function login(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|max:200|min:4',
        ]);

        if ($validator->fails()){ return response()->json(['message'=>$validator->errors()->first()], 400);  }

        $credentials = request(['email', 'password']);
        
        if (!Auth()->attempt($credentials)) {
            return response(['message'=>'Invalid credentials'],403);
        }

        return $user = Auth()->user();

    }
}
