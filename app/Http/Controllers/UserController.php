<?php

namespace App\Http\Controllers;

use App\Enum\RolesEnum;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        return Inertia::render('Users/Index', [
            'users' => AuthUserResource::collection(
                User::with(['roles', 'permissions'])
                    ->paginate()
            )
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
        ]);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        if (!empty($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }
        return back()->with('success', 'User updated successfully');

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        $user->syncRoles($validated['roles']);

        return back()->with('success', 'User created successfully');

    }

    public function create(Request $request)
    {
        $roles = RolesEnum::toArray(); // ['Admin' => 'admin', 'Commenter' => 'commenter', 'User' => 'user']

        return Inertia::render('Users/Create', [
            'roles' => $roles, // Transmet les rôles à Inertia
        ]);

    }

    public function edit(Request $request, User $user)
    {
        $roles = RolesEnum::toArray();
        return Inertia::render('Users/Edit', [
            'user' => new AuthUserResource($user),
            'roles' => $roles,
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        return to_route('users.index')->with('success', 'User has been deleted succesfully');


    }
}
