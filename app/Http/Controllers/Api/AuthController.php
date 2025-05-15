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
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $validated['photo'] = $path;
        }

        // Jika email diubah, reset verified
        if (isset($validated['email']) && $validated['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->fill($validated);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }



}
