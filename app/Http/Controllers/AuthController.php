<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create($data);
            $token = $user->createToken('authToken')->plainTextToken;

            return (new UserResource($user))->additional([
                'message' => 'User registered successfully.',
                'token' => $token,
            ]);

        } catch (Exception $e) {

            return self::errorInfo($e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'error' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user->tokens()->delete();
            $token = $user->createToken('authToken')->plainTextToken;

            return (new UserResource($user))->additional([
                'message' => 'Login successfully.',
                'token' => $token,
            ], 200);

        } catch (Exception $e) {

            return self::errorInfo($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ], 200);
    }

    public function profile(Request $request)
    {
        return new UserResource($request->user());
    }

    private function errorInfo($errorMessage)
    {
        Log::error('Something went wrong: '.$errorMessage);

        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $errorMessage,
        ], 500);
    }
}
