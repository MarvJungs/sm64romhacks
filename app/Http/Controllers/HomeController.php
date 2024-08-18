<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Version;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('created_at')->take(3)->get();
        $versions = Version::orderByDesc('created_at')->take(10)->get();
        $comments = Comment::orderByDesc('created_at')->take(5)->get();

        return view('home.index', [
            'news' => $news,
            'versions' => $versions,
            'comments' => $comments,
        ]);
    }
}
