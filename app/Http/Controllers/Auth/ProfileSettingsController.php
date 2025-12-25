<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileSettingsRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileSettingsController extends Controller
{
    public function index(?User $user = null)
    {
        $countries = Country::all();
        return view(
            'auth.settings',
            [
                'section' => 'auth.settings.account',
                'countries' => $countries,
                'user' => $user ?? Auth::user()
            ]
        );
    }

    public function handle(ProfileSettingsRequest $request)
    {
        $r = $request->validated();
        $user = $request->user();

        if (Arr::has($r, 'name')) {
            $request->user()->forceFill(['name_updated_at' => now()]);
        }

        if (Arr::has($r, 'avatar')) {
            Storage::disk('public')->delete($request->user()->avatar);
            $path = $request->file('avatar')->store('avatars', 'public');
            $r['avatar'] = $path;
        }
        
        $user->update($r);
        return redirect(route('users.show', ['user' => $user]));
    }
}