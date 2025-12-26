<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MegapackController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\NewspostsController;
use App\Http\Controllers\PatcherController;
use App\Http\Controllers\RomhackCommentsController;
use App\Http\Controllers\RomhackeventsController;
use App\Http\Controllers\RomhacksController;
use App\Http\Controllers\RomhackVersionsController;
use App\Http\Controllers\StreamsController;
use App\Models\Romhack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\CheatcodesController;
use App\Http\Controllers\ImageController;

require 'auth.php';
require 'moderation.php';

Route::get('', [HomeController::class, 'index'])->name('index');
Route::get('home', [HomeController::class, 'index'])->name('home.index');
Route::get('cheats', [CheatcodesController::class, 'index'])->name('cheats.index');
Route::get('tos', [HomeController::class, 'tos'])->name('tos');
Route::get('privacy-policy', [HomeController::class, 'privacy'])->name('privacy-policy');
Route::redirect('faq', 'https://docs.google.com/document/d/10m5ViLktz-d6SwhHtSeb7gVzDUldOqIBlJte_kr4U14/edit?usp=sharing')->name('faq');
Route::redirect('discord', 'https://discord.gg/BYrpMBG')->name('discord');
Route::redirect('support', 'https://ko-fi.com/marvjungs')->name('support');

Route::get(
    'fetchurl',
    function (Request $request) {
        if ($request->has('url')) {
            $data = [];
            $url = $request->get('url');
            $url = !Str::isUrl($url) ? 'http://' . $url : $url;
            $response = Http::get($url);
            if ($response->successful()) {
                $crawler = new Crawler($response->body());
                $title = $crawler->filter('title')->text();
                $description = $crawler->filter(
                    'meta'
                )->reduce(
                        function (Crawler $node, int $i) {
                            $name = $node->extract(['name']);
                            return $name[0] == 'description';
                        }
                    )->extract(['content']);

                $icon = $crawler->filter(
                    'link'
                )->reduce(
                        function (Crawler $node, int $i) {
                            $rel = $node->extract(['rel']);
                            return Str::contains(Str::lower($rel[0]), 'icon');
                        }
                    )->extract(['href']);
                $data['success'] = 1;
                $data['meta'] = [
                    'title' => $title,
                    'description' => $description,
                    'image' => ['url' => count($icon) > 0 ? (!Str::isUrl($icon[0]) ? $url . $icon[0] : $icon[0]) : null]
                ];
            } else {
                $data['success'] = 0;
                $data['meta'] = [];
            }
            $data['link'] = $url;
            return $data;
        }
    }
);


Route::prefix('news')->group(
    function () {
        Route::get('', [NewspostsController::class, 'index'])->name('newspost.index');
        Route::get('{newspost}', [NewspostsController::class, 'show'])->name('newspost.show');
    }
);

Route::prefix('hacks')->group(
    function () {
        Route::get('', [RomhacksController::class, 'index'])->name('hack.index');
        Route::get('random', [RomhacksController::class, 'random'])->name('hack.random');
        Route::get('create', [RomhacksController::class, 'create'])->name('hack.create')->can('create', Romhack::class);
        Route::post('create', [RomhacksController::class, 'store'])->name('hack.store')->can('create', Romhack::class);
        Route::get('download/{version}', [RomhackVersionsController::class, 'download'])->name('version.download');
        Route::prefix('{hack}')->group(
            function () {
                Route::get('', [RomhacksController::class, 'show'])->name('hack.show');
                Route::get('edit', [RomhacksController::class, 'edit'])->name('hack.edit')->can('update', 'hack');
                Route::put('edit', [RomhacksController::class, 'update'])->name('hack.update')->can('update', 'hack');
                Route::delete('delete', [RomhacksController::class, 'destroy'])->name('hack.destroy')->can('delete', 'hack');
                Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('image.destroy')->can('update', 'hack');


                Route::prefix('versions')->group(
                    function () {
                        Route::get('create', [RomhackVersionsController::class, 'create'])->name('version.create')->can('createVersion', 'hack');
                        Route::post('create', [RomhackVersionsController::class, 'store'])->name('version.store')->can('createVersion', 'hack');
                        Route::get('{version}/edit', [RomhackVersionsController::class, 'edit'])->name('version.edit')->can('update', 'version');
                        Route::put('{version}/edit', [RomhackVersionsController::class, 'update'])->name('version.update')->can('update', 'version');
                        Route::delete('{version}/delete', [RomhackVersionsController::class, 'destroy'])->name('version.destroy')->can('delete', 'version');
                    }
                );

                Route::post('comment', [RomhackCommentsController::class, 'create'])->name('comment.create')->middleware(['auth', 'verified']);
            }
        );
        Route::prefix('comments')->group(
            function () {
                Route::post('{comment}/like', [RomhackCommentsController::class, 'like'])->name('comment.like')->middleware(['auth', 'verified']);
                Route::post('{comment}/dislike', [RomhackCommentsController::class, 'dislike'])->name('comment.dislike')->middleware(['auth', 'verified']);
                Route::delete('{comment}/delete', [RomhackCommentsController::class, 'destroy'])->name('comment.destroy')->can('delete', 'comment');
            }
        );
    }
);

Route::get('megapack', [MegapackController::class, 'index'])->name('megapack.index');

Route::get('patcher', [PatcherController::class, 'index'])->name('tools.patcher');
Route::get('streams', [StreamsController::class, 'index'])->name('streams.index');

Route::get('events/{event}', [RomhackeventsController::class, 'show'])->name('event.show');
Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

Route::prefix('tools')->group(
    function () {
        Route::redirect('lunas-project64', 'https://github.com/Luna-Project64/Luna-Project64/releases/latest')->name('tools.emulator');
        Route::redirect('stardisplay', 'https://github.com/aglab2/SM64StarDisplay/releases/latest')->name('tools.stardisplay');
        Route::redirect('hacktice', 'https://github.com/aglab2/hacktice/releases/latest')->name('tools.hacktice');
    }
);



Route::post(
    '{path}/images/upload',
    function (Request $request, string $path) {
        if ($request->exists('image')) {
            // $path = $request->file('image')->store($path, 'public');
            return [
                'success' => 0,
            ];
            dd($request->file('image'));
        }
    }
);
