<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Version;
use App\Models\News;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class HomeController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('created_at')->take(3)->get();
        $versions = Version::orderByDesc('created_at')->take(10)->get();
        $comments = Comment::orderByDesc('created_at')->take(5)->get();

        SEOMeta::setTitle('Home');

        OpenGraph::setTitle('Home');
        OpenGraph::setDescription('A quick overview of the recent activities related to our community!');
        OpenGraph::setType('Articles');


        return view('home.index', [
            'news' => $news,
            'versions' => $versions,
            'comments' => $comments,
        ]);
    }
}
