<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    // Validasi data (bisa sesuaikan aturan validasi)
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'phone' => 'sometimes|string|max:20',
        'photo' => 'sometimes|image|max:2048', // max 2MB misalnya
    ]);

    // Simpan foto profil jika ada
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('profile_photos', 'public');
        $validated['photo'] = $path;
    }

    // Jika email diubah, reset verifikasi email
    if (isset($validated['email']) && $validated['email'] !== $user->email) {
        $user->email_verified_at = null;
    }

    $user->fill($validated);
    $user->save();

    // Buat URL lengkap untuk foto, jika ada
    $photoUrl = $user->photo ? asset('storage/' . $user->photo) : null;

    return response()->json([
        'status' => 'success',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'email_verified_at' => $user->email_verified_at,
            'photo' => $user->photo,
            'photo_url' => $photoUrl,
            'role' => $user->role,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ],
    ]);
}












}
