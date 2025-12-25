<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SocialiteController extends Controller
{
    public function redirect(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver)
    {
        $authUser = Socialite::driver($driver)->user();
        $defaultRoles = User::all()->count() == 0 ? Role::where(['priority' => 0])->get() : Role::where(['priority' => Role::max('priority')])->get();
        $user = User::where(['email' => $authUser->getEmail()])->first();
        if ($user) {
            $user->update([$driver . '_id' => $authUser->getId()]);
        } else {
            Storage::put("avatars/{$authUser->getId()}.png", Http::get($authUser->getAvatar())->getBody());
            $user = User::create(
                [
                    'name' => $authUser->getName(),
                    'email' => $authUser->getEmail(),
                    $driver . '_id' => $authUser->getId(),
                    'avatar' => "avatars/{$authUser->getId()}.png"
                ]
            );
            $user->roles()->attach($defaultRoles->modelKeys());
            event(new Registered($user));
        }
        Auth::login($user, true);
        return redirect('/');
    }
}
