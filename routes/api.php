<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// Login route
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['Les identifiants sont incorrects.'],
        ]);
    }

    return response()->json([
        'token' => $user->createToken('react-token')->plainTextToken,
        'user' => $user,
    ]);
});

// Route protégée
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Déconnexion
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Déconnecté']);
});

