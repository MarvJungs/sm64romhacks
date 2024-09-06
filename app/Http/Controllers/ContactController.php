<?php

namespace App\Http\Controllers;

use App\Mail\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(User $user)
    {
        if (!Auth::check()) {
            abort(401);
        }

        $user = Auth::user();
        return view('contact.index', compact('user'));
    }

    public function send(Request $request)
    {
        if (!Auth::check()) {
            abort(401);
        }

        $user = Auth::user();
        Mail::to('feedback@sm64romhacks.com')->send(new Feedback($request, $user));

        return redirect(route('home.index'))->with('success', 'feedback submitted');
    }
}
