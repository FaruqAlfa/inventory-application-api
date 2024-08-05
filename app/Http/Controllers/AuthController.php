<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(request $request)
    {
        //validation request login user with email and password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //check email
        $user = User::where('email', $request->email)->first();

        //check password with hash
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Login gagal'
            ], 401);
        }

        //if login success create token
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => true,
            'data' => ['token' => $token],
            'message' => 'Login Success'
        ]);
    }
}
