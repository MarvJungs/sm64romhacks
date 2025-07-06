<?php

namespace App\Http\Controllers;

use App\Models\Newspost;
use Illuminate\Http\Request;

class NewspostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsposts = Newspost::all();
        return view('news.index')->with('newsposts', $newsposts);
    }

    /**
     * Show the form for creating/editing a new resource.
     */
    public function manage(Request $request, ?Newspost $newspost)
    {
        if (!$request->user()?->isAuthorOf($newspost)) {
            abort(403);
        }
        return view('moderation.newsposts.manage')->with('newspost', $newspost);
    }

    /**
     * Store or Update a newly created/updated resource in storage.
     */
    public function store(Request $request, ?Newspost $newspost = null)
    {
        $request['text'] = json_decode($request['text'], true);
        $r = $request->validate(
            [
                'title' => 'required|string|max:100',
                'text' => 'required|array',
                'text.blocks' => 'required|min:1',
                'text.time' => 'required|numeric',
                'text.version' => 'required|string'
            ]
        );

        if (!is_null($newspost)) {
            $newspost->update($r);
        } else {
            $newspost = $request->user()->newsposts()->create($r);
        }
        return redirect(route('newspost.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Newspost $newspost)
    {
        return view('news.view')->with('newspost', $newspost);
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
        return view('moderation.newsposts.delete')->with('newspost', $newspost);
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
