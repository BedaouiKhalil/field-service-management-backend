<?php

namespace App\Http\Controllers\Web;

use App\Constants\Permissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AddRequest;
use App\Http\Requests\User\EditRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        private UserService $service
    ) {
        $this->middleware('permission:' . Permissions::VIEW_USER)->only(['index', 'show']);
        $this->middleware('permission:' . Permissions::MANAGE_USER)->only(['store', 'edit', 'create', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->service->list($request->all());

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Users created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->get();
        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, User $user)
    {
        $this->service->update($request->validated(), $user);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'User deleted successfully.');
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');
        $role = $request->get('role');

        if (!$role) {
            return response()->json([]);
        }

        $technicians = User::role($role)
            ->select('id', 'first_name', 'last_name')
            ->when($search, function ($query, $search) {
                return $query->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'full_name' => $user->first_name . ' ' . $user->last_name
                ];
            });

        return response()->json($technicians);
    }
}
