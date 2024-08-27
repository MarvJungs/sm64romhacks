<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use App\Models\Role;
use Throwable;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $roles = Role::all()->pluck('name', 'id')->toArray();
        try {
            if (!session()->exists('guildMemberRoles')) {
                session()->put('guildMemberRoles', $user->getGuildMember(703951576162762813)->roles);
            }
            $guildMemberRoles = session()->get('guildMemberRoles');
        } catch (Throwable $th) {
            $guildMemberRoles = null;
        }

        return view('profile.index', [
            'user' => $user,
            'versions' => $user->author?->versions,
            'comments' => $user->comments,
            'guildMemberRoles' => $guildMemberRoles,
            'roles' => $roles
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        $user = Auth::user();
        $countries = Http::get(
            'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries.json'
        )->json();

        return view('profile.edit', [
            'user' => $user,
            'countries' => $countries
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->update([
            'gender' => $request->gender,
            'country' => $request->country,
            'notify' => filter_var($request->notify, FILTER_VALIDATE_BOOLEAN)
        ]);
        return Redirect::route('profile.index');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
