<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function login(array $credentials, string $device)
    {
        $user = User::whereEmail($credentials['email'])
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $user->tokens()->where('name', $device)->delete();

        return [
            'user'  => new UserResource($user),
            'token' => $user->createToken($device)->plainTextToken,
        ];
    }
}
