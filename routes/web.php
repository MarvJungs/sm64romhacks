<?php

use App\Http\Controllers\CheatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HackController;
use App\Http\Controllers\MegapackController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\TermsOfServiceController;
use App\Http\Controllers\PatchController;
use App\Http\Controllers\VersionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DisruptionController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/stardisplay', 'https://github.com/aglab2/SM64StarDisplay')->name('stardisplay');
Route::redirect('/plugins', 'https://sites.google.com/view/shurislibrary/plugin-guide')->name('plugins');
Route::redirect('/faq', 'https://docs.google.com/document/d/10m5ViLktz-d6SwhHtSeb7gVzDUldOqIBlJte_kr4U14/edit#heading=h.ynvmen1681ne')->name('faq');
Route::redirect('/discord', 'https://discord.com/invite/BYrpMBG')->name('discord');
Route::redirect('/support', 'https://ko-fi.com/marvjungs')->name('support');

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('hacks/download/{version}', [HackController::class, 'download'])->name('hack.download');
Route::get('hacks/random', [HackController::class, 'random'])->name('hack.random');
Route::get('hacks/{hack}/create', [VersionController::class, 'create'])->name('version.create');
Route::get('hacks/{hack}/{version}/edit', [VersionController::class, 'edit'])->name('version.edit');
Route::get('megapack', [MegapackController::class, 'index'])->name('megapack.index');
Route::get('megapack/download', [MegapackController::class, 'download'])->name('megapack.download');
Route::get('patcher', [PatchController::class, 'index'])->name('patcher.index');
Route::get('/streams', [StreamController::class, 'index'])->name('streams.index');
Route::get('/tos', [TermsOfServiceController::class, 'index'])->name('tos.index');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.name');
Route::get('apps/league2022', [AppController::class, 'league2022'])->name('apps.league2022');
Route::get('apps/league2023', [AppController::class, 'league2023'])->name('apps.league2023');
Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

Route::resource('/events', EventController::class)->except(['show', 'index'])
    ->middleware('checkrole:705528172581486704');
Route::resource('cheats', CheatController::class);
Route::resource('events', EventController::class)->only(['show']);
Route::resource('hacks', HackController::class);
Route::resource('hacks/{hack}/version', VersionController::class)->except(['create', 'edit']);
Route::resource('news', NewsController::class);
Route::resource('/moderation/disruptions', DisruptionController::class);

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware('checkrole:705528172581486704')->group(function () {
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::resource('/moderation/events', EventController::class)->only('index')->name('index', 'events.index');
});

Route::middleware('checkrole:705528172581486704')->group(function () {
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

Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');
Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('contact', [ContactController::class, 'send'])->name('contact.send');
