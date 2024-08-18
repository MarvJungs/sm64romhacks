<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Version;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public string $latest_runs_url = 'https://www.speedrun.com/api/v2/GetLatestLeaderboard?_r=eyJzZXJpZXNJZCI6IjA0OTlvNjR2IiwidmFyeSI6MTcxNjg2ODE4OX0';
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
