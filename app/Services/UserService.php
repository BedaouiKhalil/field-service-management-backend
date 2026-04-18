<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function list(array $params)
    {
        $query = User::with(['roles']);

        $keyword = data_get($params, 'keyword');

        if (!empty($keyword)) {
            if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
            }
        }

        $limit = min(data_get($params, 'limit', config('app.defaults.pagination_limit', 10)), 100);

        return $query->latest()->paginate($limit);
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->assignRole($data['role']);

            return $user;
        });
    }

    public function update(array $data, User $user)
    {
        return DB::transaction(function () use ($data, $user) {

            $user->update([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['email'],
            ]);

            $user->syncRoles([$data['role']]);

            return $user;
        });
    }
}
