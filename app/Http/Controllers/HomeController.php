<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Newspost;
use App\Models\Version;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Returns the Homepage
     * 
     * @return View
     */
    public function index(): View
    {
        $newsposts = Newspost::orderByDesc('created_at')->limit(5)->get();
        $comments = Comment::orderByDesc('created_at')->limit(5)->get();
        $versions = Version::orderByDesc('created_at')->limit(5)->get();

        return view(
            'welcome',
            [
                'newsposts' => $newsposts,
                'comments' => $comments,
                'versions' => $versions
            ]
        );
    }

    public function tos()
    {
        return view('terms-of-service');
    }

    public function privacy()
    {
        return view('privacy-policy');
    }
}
