<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
            'phone' => ['required', 'digits_between:10,15'],
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);


        $token = $user->createToken($user->email)->plainTextToken;

        return ResponseHelper::jsonResponseMethod(data: $user,token: $token, status: 'success');
    }


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

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return ResponseHelper::jsonResponseMethod(status: 'success', message: 'successfully log out');
    }

    public function updateProfile(Request $request)
    {
        $user = app('auth')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048', // optional upload photo
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        return ResponseHelper::jsonResponseMethod(data: $user, status: 'success');
    }

}
