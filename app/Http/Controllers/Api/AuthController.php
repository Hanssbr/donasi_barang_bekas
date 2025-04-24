<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !password_verify($request->password, $user->password)){
            return ResponseHelper::jsonResponseMethod(status: 'error', message: 'invalid credential');
        }

        return response()->json([
            'token' => $user->createToken($user->email)->plainTextToken,
            'user' => $user
        ]);
    }
}
