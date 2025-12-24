<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Author;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(100);
        return view('admin.users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $author = Author::where(['user_id' => $user->id])->first();
        return view('users.profile', ['user' => $user, 'author' => $author]);

    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('admin.users.index'));
    }

    public function roles(User $user)
    {
        $roles = Role::where('priority', '>', 1)->get();
        return view('admin.users.roles', ['roles' => $roles, 'user' => $user]);
    }

    public function setRoles(Request $request, User $user)
    {
        $roles = collect($request->get('roles'));
        if ($user->hasRole('admin')) {
            $roles = $roles->merge(['Admin']);
        }
        $ids = $roles->map(fn($role) => Role::where('name', '=', $role)->first());
        $user->roles()->detach();
        $user->roles()->attach($ids);
        return redirect(route('admin.users.index'));
    }
}
