<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Author;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all()->pluck('name', 'id')->toArray();
        return view('users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function show(User $user)
    {
        SEOMeta::setTitle($user->global_name);

        OpenGraph::setTitle($user->global_name);
        OpenGraph::setType('Profile');
        OpenGraph::addImage($user->getAvatar());

        $roles = Role::all()->pluck('name', 'id')->toArray();
        $guildMemberRoles = $user->getRoles();

        return view('users.show', [
            'user' => $user,
            'versions' => $user->author?->versions,
            'comments' => $user->comments->sortByDesc('created_at'),
            'guildMemberRoles' => $guildMemberRoles,
            'roles' => $roles,
        ]);
    }

    public function manage()
    {
        $allUsers = User::all()->sortBy('global_name');
        $allAuthors = Author::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        return view('users.manage', [
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

        return redirect(route('users.index'));
    }

    public function assignAuthorToUser(UpdateUserRequest $request)
    {
        $author = Author::find($request->author_id);
        $author->update([
            'user_id' => $request->user_id
        ]);
        return redirect(route('home.index'))->with('success', 'assigned author successfully');
    }
}
