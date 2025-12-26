<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function index()
    {
        return view('auth.verify-email');
    }

    public function handle(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/');
    }

    public function sendNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
