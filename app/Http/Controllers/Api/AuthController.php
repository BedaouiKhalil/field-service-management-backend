<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::whereEmail($request->email)
            ->select(['id', 'name', 'email', 'password',])
            ->with('roles:name')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponse::sendResponse(401, 'Invalid credentials');
        }

        $user->tokens()->where('name', $request->input('device_name'))->delete();
        $token = $user->createToken($request->input('device_name'))->plainTextToken;

        $data = [
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ];

        return ApiResponse::sendResponse(200, 'Login successful', $data);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return ApiResponse::sendResponse(
            200,
            'User data retrieved successfully',
            new UserResource($user)
        );
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()?->delete();

        return ApiResponse::sendResponse(200, 'Logout successful');
    }
}
