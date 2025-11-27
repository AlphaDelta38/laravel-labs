<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function register(RegisterUserRequest $request)
	{
		$user = User::create($request->validated());

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json(['token' => $token], 201);
	}

	public function login(Request $request)
	{
		$credentials = $request->only(['email', 'password']);

		if (Auth::attempt($credentials)) {
			$user = Auth::user();
			$user->tokens()->delete();
			$token = $user->createToken('auth_token')->plainTextToken;
			return response()->json(['token' => $token], 200);
		} else {
			return response()->json(['message' => 'Invalid credentials.'], 401);
		}
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();
		return response()->json(['message' => 'Logged out'], 200);
	}
}
