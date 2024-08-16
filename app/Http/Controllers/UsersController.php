<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
            'versions' => $user->author?->versions,
            'comments' => $user->comments->sortByDesc('created_at')
        ]);
    }

    public function manage()
    {
        $users = User::all()->filter(function (User $user, int $key) {
            return Auth::user()->display_name != $user->display_name &&
                Auth::user()->role->priority < $user->role->priority;
        });

        $roles = Role::all()->filter(function (Role $role, int $key) {
            return Auth::user()->role->priority < $role->priority;
        });

        $allUsers = User::all()->sortBy('display_name');
        $allAuthors = Author::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);


        return view('users.manage', [
            'users' => $users,
            'roles' => $roles,
            'allUsers' => $allUsers,
            'allAuthors' => $allAuthors
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::find($request->user_id);
        $user->update([
            'role_id' => $request->role_id
        ]);

        return redirect('/users');
    }

    public function assignAuthorToUser(UpdateUserRequest $request)
    {

        $user = User::find($request->user_id);
        $user->update([
            'author_id' => $request->author_id
        ]);
        return redirect('/')->with('success', 'assigned author successfully');
    }
}
