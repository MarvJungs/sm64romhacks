<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Hack;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all()->sortByDesc('created_at');

        return view('comments.index', [
            'comments' => $comments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $hack = Hack::find($request->hack_id);
        if (!$hack) {
            abort(404, 'hack not found');
        }
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'hack_id' => $request->hack_id,
            'title' => $request->title,
            'text' => $request->text
        ]);
        return redirect('/hacks/' . $hack->id . '#comments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect('/moderation/comments')->with('success', 'comment has been deleted');
    }
}
