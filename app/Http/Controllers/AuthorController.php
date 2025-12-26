<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Requests\UpdateAuthorUserRequest;
use App\Models\User;
use Illuminate\Support\Arr;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::orderBy('name')->paginate(100);
        return view('admin.authors.index', ['authors' => $authors]);
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', ['author' => $author]);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $r = $request->validated();
        $author->update(['name' => $r['newName']]);
        return redirect(route('admin.authors.index'));
    }

    public function destroy(DestroyAuthorRequest $request, Author $author)
    {
        $request->validated();
        $author->delete();
        return redirect(route('admin.authors.index'));
    }

    public function setUser(Author $author)
    {
        $author_users = Author::all()->pluck('user_id')->unique();
        $users = User::all()->whereNotIn('id', $author_users);
        return view('admin.authors.user', ['author' => $author ,'users' => $users]);
    }

    public function updateUser(UpdateAuthorUserRequest $request, Author $author)
    {
        $r = $request->validated();
        $author->user()->associate(User::find($r['user_id']));
        $author->save();
        return redirect(route('admin.authors.index'));
    }
}
