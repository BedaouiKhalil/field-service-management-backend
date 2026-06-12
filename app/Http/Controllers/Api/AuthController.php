<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Api\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    private AuthService $service;

    public function __construct(AuthService  $authService)
    {
        $this->middleware('throttle:5,1')->only('login');
        $this->service = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $deviceName = $request->input('device_name', $request->userAgent());

        $data = $this->service->login($credentials, $deviceName);

        if (!$data) {
            return ApiResponse::error(message: 'Identifiants invalides', code: Response::HTTP_UNAUTHORIZED);
        }

        return ApiResponse::success(message: 'Login successful', data: $data);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return ApiResponse::success(
            message: 'User data retrieved successfully',
            data: new UserResource($user)
        );
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()?->delete();

        return ApiResponse::success(message: 'Logout successful');
    }
}
