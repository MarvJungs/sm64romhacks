<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredMail;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function redirectToDiscord()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleDiscordCallback()
    {
        $discord_user = Socialite::driver('discord')->user();
        $role_id = User::count('id') == 0 ? 1 : 5;
        $user = User::find($discord_user->id);
        $data = [
            'user_name' => $discord_user->user['username'],
            'display_name' => $discord_user->user['global_name'],
            'email' => $discord_user->email,
            'avatar' => $discord_user->avatar,
            'token' => $discord_user->token,
            'refreshToken' => $discord_user->refreshToken
        ];

        if ($user) {
            $user->update($data);
        } else {
            $user = User::create(
                array_merge($data, ['id' => $discord_user->id, 'role_id' => $role_id])
            );
            dd(Mail::to($user->email)->send(new RegisteredMail($user)));
        }
        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
