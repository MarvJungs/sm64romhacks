<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewspostRequest;
use App\Http\Requests\UpdateNewspostRequest;
use App\Models\Newspost;
use Illuminate\Http\Request;

class NewspostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsposts = Newspost::all()->sortByDesc('created_at');
        return view('news.index')->with('newsposts', $newsposts);
    }

    public function create()
    {
        return view('news.create');
    }

    public function edit(Newspost $newspost)
    {
        return view('news.edit', ['newspost' => $newspost]);
    }

    /**
     * Store or Update a newly created/updated resource in storage.
     */
    public function store(StoreNewspostRequest $request, ?Newspost $newspost = null)
    {
        $request->user()->newsposts()->create($request->validated());
        return redirect(route('newspost.index'));
    }

    public function update(UpdateNewspostRequest $request, Newspost $newspost)
    {
        $newspost->update($request->validated());
        return redirect(route('newspost.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Newspost $newspost)
    {
        return view('news.view', ['newspost' => $newspost]);
    }

    /**
     * Shows the confirmation window for deleting a resource
     * 
     * @param \App\Models\Newspost $newspost Newspost
     * 
     * @return void
     */
    public function delete(Request $request, Newspost $newspost)
    {
        if (!$request->user()?->isAuthorOf($newspost)) {
            abort(403);
        }
        return view('news.delete', ['newspost' => $newspost]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newspost $newspost)
    {
        $newspost->delete();
        return redirect(route('newspost.index'));
    }
}
