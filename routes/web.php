<?php

use App\Http\Controllers\CheatController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HackController;
use App\Http\Controllers\MegapackController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\TermsOfServiceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PatchController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DisruptionController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/news');
Route::redirect('/stardisplay', 'https://github.com/aglab2/SM64StarDisplay');
Route::redirect('/plugins', 'https://sites.google.com/view/shurislibrary/plugin-guide');
Route::redirect('/faq', 'https://docs.google.com/document/d/10m5ViLktz-d6SwhHtSeb7gVzDUldOqIBlJte_kr4U14/edit#heading=h.ynvmen1681ne');
Route::redirect('/discord', 'https://discord.com/invite/BYrpMBG');
Route::redirect('/support', 'https://ko-fi.com/marvjungs');
Route::redirect('login', 'auth/discord');

Route::get('hacks/download/{version}', [HackController::class, 'download']);
Route::get('hacks/random', [HackController::class, 'random']);
Route::get('hacks/{hack}/create', [VersionController::class, 'create']);
Route::get('hacks/{hack}/{version}/edit', [VersionController::class, 'edit']);
Route::get('megapack', [MegapackController::class, 'index']);
Route::get('megapack/download', [MegapackController::class, 'download']);
Route::get('patcher', [PatchController::class, 'index']);
Route::get('/streams', [StreamController::class, 'index']);
Route::get('/tos', [TermsOfServiceController::class, 'index']);
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index']);
Route::get('auth/discord', [LoginController::class, 'redirectToDiscord']);
Route::get('auth/discord/login', [LoginController::class, 'handleDiscordCallback']);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('apps/league2022', [AppController::class, 'league2022'])->name('apps.league2022');
Route::get('apps/league2023', [AppController::class, 'league2023'])->name('apps.league2023');
Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

Route::resource('/events', EventController::class)->only([
    'create',
    'store',
    'edit',
    'update'
])->middleware('checkrole:3,2,1');
Route::resource('cheats', CheatController::class);
Route::resource('events', EventController::class)->only(['show']);
Route::resource('hacks', HackController::class);
Route::resource('hacks/{hack}/version', VersionController::class);
Route::resource('news', NewsController::class);
Route::resource('/moderation/disruptions', DisruptionController::class);

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('checkrole:3,2,1')->group(function () {
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::resource('/moderation/events', EventController::class)->only('index')->name('index', 'events.index');
});

Route::middleware('checkrole:1,2')->group(function () {
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/moderation/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/moderation/hacks', [HackController::class, 'unverified'])->name('hacks.unverified');
    Route::get('/moderation/hacks/manage', [HackController::class, 'manage'])->name('hacks.manage');
    Route::get('/moderation/users', [UsersController::class, 'manage'])->name('users.manage');
    Route::patch('/users', [UsersController::class, 'update'])->name('users.update');
    Route::patch('/authors', [UsersController::class, 'assignAuthorToUser'])->name('users.assignAuthorToUser');

    Route::patch('/hacks', [HackController::class, 'reject'])->name('hacks.reject');
    Route::put('/hacks', [HackController::class, 'accept'])->name('hacks.accept');
});
