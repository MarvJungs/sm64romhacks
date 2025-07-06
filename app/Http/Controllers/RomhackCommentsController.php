<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Commentrating;
use App\Models\Romhack;
use Illuminate\Http\Request;

class RomhackCommentsController extends Controller
{
    /**
     * Summary of create
     * 
     * @param \Illuminate\Http\Request $request Request
     * @param \App\Models\Romhack      $hack    Romhack
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, Romhack $hack)
    {
        $r = $request->validate(
            [
                'text' => 'required|string'
            ]
        );
        Comment::create(
            [
                'romhack_id' => $hack->id,
                'user_id' => $request->user()->id,
                'text' => ((object) $r)->text
            ]
        );
        return redirect(route('hack.show', ['hack' => $hack]));
    }

    /**
     * Liking a Comment
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(Request $request, Comment $comment)
    {
        return $this->rate($request, $comment, 1);
    }

    /**
     * Disliking a Comment
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dislike(Request $request, Comment $comment)
    {
        return $this->rate($request, $comment, -1);
    }

    /**
     * Rate A Comment
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Comment $comment
     * @param int $value
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function rate(Request $request, Comment $comment, int $value)
    {
        if ($request->user()->hasLikedComment($comment) || $request->user()->hasDislikedComment($comment)) {
            $rating = $comment->ratings->where('user_id', $request->user()->id)->first();
            $rating->delete();
        } else {
            $rating = Commentrating::createOrFirst(
                [
                    'user_id' => $request->user()->id,
                    'comment_id' => $comment->id,
                    'rating' => $value
                ]
            );
        }
        return redirect(route('hack.show', ['hack' => $comment->romhack, "#$comment->id"]));
    }

    public function delete(Request $request, Comment $comment)
    {
        if (!$request->user()?->isAuthorOf($comment)) {
            abort(403);
        }
        return view('comments.delete', ['comment' => $comment]);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if (!$request->user()?->isAuthorOf($comment)) {
            abort(403);
        }
        $comment->delete();
        return redirect(route('hack.show', ['hack' => $comment->romhack, "#comments"]));
    }
}
