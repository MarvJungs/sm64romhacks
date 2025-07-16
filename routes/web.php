<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MegapackController;
use App\Http\Controllers\NewspostsController;
use App\Http\Controllers\PatcherController;
use App\Http\Controllers\RomhackCommentsController;
use App\Http\Controllers\RomhacksController;
use App\Http\Controllers\RomhackVersionsController;
use App\Http\Controllers\StreamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

require 'auth.php';
require 'moderation.php';

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('home', [HomeController::class, 'index'])->name('home.index');
Route::redirect('/faq', 'https://docs.google.com/document/d/10m5ViLktz-d6SwhHtSeb7gVzDUldOqIBlJte_kr4U14/edit?usp=sharing')->name('faq');
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

Route::get('news', [NewspostsController::class, 'index'])->name('newspost.index');
Route::get('news/{newspost}', [NewspostsController::class, 'show'])->name('newspost.show');
Route::get('hacks', [RomhacksController::class, 'index'])->name('hack.index');
Route::get('hacks/random', [RomhacksController::class, 'random'])->name('hack.random');
Route::get('hacks/manage/{hack?}', [RomhacksController::class, 'manage'])->name('hack.manage')->middleware(['auth', 'verified']);
Route::post('hacks/manage/{hack?}', [RomhacksController::class, 'store'])->name('hack.store');
Route::get('hacks/{hack}', [RomhacksController::class, 'show'])->name('hack.show');
Route::get('hacks/{hack}/delete', [RomhacksController::class, 'delete'])->name('hack.delete');
Route::delete('hacks/{hack}/delete', [RomhacksController::class, 'destroy'])->name('hack.destroy');

Route::get('hacks/download/{version}', [RomhackVersionsController::class, 'download'])->name('version.download');
Route::get('hacks/{hack}/versions/create', [RomhackVersionsController::class, 'manage'])->name('version.create');
Route::post('hacks/{hack}/versions/create', [RomhackVersionsController::class, 'store'])->name('version.store');
Route::get('hacks/{hack}/versions/{version}/edit', [RomhackVersionsController::class, 'manage'])->name('version.edit');
Route::put('hacks/{hack}/versions/{version}/edit', [RomhackVersionsController::class, 'store'])->name('version.update');
Route::get('hacks/{hack}/versions/{version}/delete', [RomhackVersionsController::class, 'delete'])->name('version.delete');
Route::delete('hacks/{hack}/versions/{version}/delete', [RomhackVersionsController::class, 'destroy'])->name('version.delete');
Route::post('hacks/{hack}/comment', [RomhackCommentsController::class, 'create'])->name('comment.create');
Route::post('hacks/comments/{comment}/like', [RomhackCommentsController::class, 'like'])->name('comment.like');
Route::post('hacks/comments/{comment}/dislike', [RomhackCommentsController::class, 'dislike'])->name('comment.dislike');
Route::get('hacks/comments/{comment}', [RomhackCommentsController::class, 'delete'])->name('comment.delete');
Route::delete('hacks/comments/{comment}', [RomhackCommentsController::class, 'destroy'])->name('comment.destroy');

Route::get('megapack', [MegapackController::class, 'index'])->name('megapack.index');
Route::get('megapack/download', [MegapackController::class, 'download'])->name('megapack.download');

Route::get('patcher', [PatcherController::class, 'index'])->name('patcher.index');
Route::get('streams', [StreamsController::class, 'index'])->name('streams.index');


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