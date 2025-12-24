<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRomhackVersionRequest;
use App\Http\Requests\UpdateRomhackVersionRequest;
use App\Models\Author;
use App\Models\Romhack;
use App\Models\Version;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class RomhackVersionsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRomhackVersionRequest $request, Romhack $hack)
    {
        $r = $request->validated();
        $authorNames = Arr::get(Arr::get(Arr::get($r, 'version'), 'author'), 'name');
        $path = $request->file('version.filename')->store('patch', 'public');
        Arr::set($r, 'version.filename', $path);

        $version = $hack->versions()->create(Arr::get($r, 'version'));
        foreach ($authorNames as $author) {
            $a = Author::createOrFirst(['name' => $author]);
            $version->authors()->attach($a->id);
        }
        return redirect(route('hack.show', ['hack' => $hack]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(UpdateRomhackVersionRequest $request, Romhack $hack, Version $version)
    {
        $r = $request->validated();
        $authorNames = Arr::get(Arr::get(Arr::get($r, 'version'), 'author'), 'name');
        $version->update(Arr::get($r, 'version'));
        $version->authors()->detach();

        foreach ($authorNames as $author) {
            $a = Author::createOrFirst(['name' => $author]);
            $version->authors()->attach($a->id);
        }
        return redirect(route('hack.show', ['hack' => $hack]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function create(Romhack $hack)
    {
        $authors = Author::all()->sortBy('name');
        return view('hacks.versions.create', ['hack' => $hack, 'authors' => $authors]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Romhack $hack, Version $version)
    {
        $authors = Author::all()->sortBy('name');
        return view('hacks.versions.edit', ['version' => $version, 'authors' => $authors]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Romhack $hack, Version $version)
    {
        if ($request->user()->cannot('delete', $version)) {
            abort(403);
        }

        $version->delete();
        Storage::disk('public')->delete($version->filename);
        if ($hack->versions()->count() > 0) {
            return redirect(route('hack.show', ['hack' => $hack]));
        } else {
            $hack->delete();
            return redirect(route('hack.index'));
        }
    }

    /**
     * Downloads the Patchfile
     * 
     * @param \App\Models\Version $version Patchfile
     * 
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Version $version)
    {
        $CrawlerDetect = new CrawlerDetect();
        if (!$CrawlerDetect->isCrawler()) {
            $version->increment('downloadcount');
        }
        return Storage::download($version->filename);
    }
}
