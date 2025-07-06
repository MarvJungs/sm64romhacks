<?php 

use App\Models\Country;
use App\Models\User;
use App\Models\Role;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;


Route::get(
    'auth/redirect/{driver}', function (string $driver) {
        return Socialite::driver($driver)->redirect();
    }
);

Route::get(
    'auth/callback/{driver}', function (string $driver) {
        $authUser = Socialite::driver($driver)->user();
        $defaultRoles = Role::where(['priority' => Role::max('priority')])->get();
        $user = User::where(['email' => $authUser->getEmail()])->first();
        if ($user) {
            $user->update([$driver.'_id' => $authUser->getId()]);
        } else {
            $user = User::create(
                [
                'name' => $authUser->getName(),
                'email' => $authUser->getEmail(),
                $driver.'_id' => $authUser->getId(),
                'avatar' => '/images/profile/default.png'
                ]
            );
            $user->roles()->attach($defaultRoles->modelKeys());
            event(new Registered($user));
        }
        Auth::login($user);
        return redirect('/');
    }
);

Route::post(
    'auth/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
);

Route::get(
    'auth/forgot-password', function () {
        return view('auth.forgot-password');
    }
)->middleware('guest')->name('password.request');

Route::post(
    'auth/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::ResetLinkSent
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
)->middleware('guest')->name('password.email');

Route::get(
    'auth/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    }
)->middleware('guest')->name('password.reset');

Route::post(
    'auth/reset-password/{token}', function (Request $request, string $token) {
        $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]
        );

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(
                    [
                        'password' => Hash::make($password)
                    ]
                )->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
)->middleware('guest')->name('password.update');

Route::get(
    'login', function () {
        return view('auth.login');
    }
)->name('login');

Route::post(
    'login', function (Request $request) {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended();
        }
        return back()->withErrors(
            [
                'email' => 'Your Email did not match with your password.'
            ]
        )->onlyInput('email');
    }
);

Route::get(
    'register', function () {
        $countries = Country::all();
        return view('auth.register', ['countries' => $countries]);
    }
);

Route::post(
    'register', function (Request $request) {
        $defaultRoles = Role::where(['priority' => Role::max('priority')])->get();
        $request->validate(
            [
                'name' => 'required|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed'
            ]
        );
        $user = User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'avatar' => 'images/profile/default.png'
            ]
        );
        $user->roles()->attach($defaultRoles->modelKeys());
        event(new Registered($user));
        Auth::login($user);
        return redirect(route('verification.notice'));
    }
);

Route::get(
    'email/verify', function () {
        return view('auth.verify-email');
    }
)->name('verification.notice');

Route::get(
    '/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    }
)->middleware(['auth', 'signed'])->name('verification.verify');

Route::post(
    '/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
)->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get(
    'profile', function () {
        return 'hello world';
    }
)->middleware(['auth', 'verified']);

Route::get(
    '/settings/account', function () {
        $countries = Country::all();
        return view(
            'auth.settings', [
            'section' => 'auth.settings.account',
            'countries' => $countries,
            ]
        );
    }
)->middleware(['auth', 'verified']);

Route::post(
    'settings/account', function (Request $request) {
        $r = $request->validate(
            [
                'name' => 'sometimes|required|string|unique:users,name',
                'email' => 'sometimes|required|email|unique:users,email|confirmed',
                'password' => 'sometimes|required|min:8|confirmed',
                'avatar' => 'sometimes|required|image|max:8192|dimensions:ratio=1',
                'description' => 'sometimes|required|string',
                'country_id' => 'sometimes|required|integer',
            ]
        );
        if (Arr::exists($r, 'name')) {
            Arr::set($r, 'name_updated_at', now());
        }

        if (Arr::exists($r, 'avatar')) {
            Storage::disk('public')->delete($request->user()->avatar);
            $path = $request->file('avatar')->store('avatars', 'public');
            Arr::set($r, 'avatar', $path);
        }
        
        $request->user()->update($r);
        dd($request->user()->password);
    }
);

Route::post(
    'auth/delete', function (Request $request) {
        $user = $request->user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if (!is_null($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        $request->user()->deleteOrFail();
        return redirect('/');
    }
)->middleware(['auth', 'verified']);