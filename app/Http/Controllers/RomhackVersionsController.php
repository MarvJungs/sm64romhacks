<?php

namespace App\Http\Controllers;

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
    public function store(Request $request, Romhack $hack, ?Version $version = null)
    {
        $r = $request->validate(
            [
                'version.name' => 'required|string',
                'version.starcount' => 'required|integer|numeric|gte:0',
                'version.releasedate' => 'required|date',
                'version.filename' => 'exclude_if:_method,PUT|required|file|filled|extensions:zip',
                'version.demo' => 'required|bool',
                'version.recommened' => 'required|bool',
                'version.author.name' => 'required|array|min:1',
                'version.author.name.*' => 'required|string'
            ]
        );
        $authorNames = Arr::get(Arr::get(Arr::get($r, 'version'), 'author'), 'name');
        if ($request->isMethod('POST')) {
            $path = $request->file('version.filename')->store('patch', 'public');
            Arr::set($r, 'version.filename', $path);
        }

        if (is_null($version)) {
            $version = $hack->versions()->create(Arr::get($r, 'version'));
        } else {
            $version->update(Arr::get($r, 'version'));
            $version->authors()->detach();
        }
        foreach ($authorNames as $author) {
            $a = Author::createOrFirst(['name' => $author]);
            $version->authors()->attach($a->id);
        }
        return redirect(route('hack.show', ['hack' => $hack]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function manage(Romhack $hack, ?Version $version)
    {
        $authors = Author::all()->sortBy('name');
        return view('hacks.versions.manage', ['version' => $version, 'authors' => $authors]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Romhack $hack, Version $version)
    {
        return view('hacks.versions.delete', ['hack' => $hack, 'version' => $version]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Romhack $hack, Version $version)
    {
        $version->delete();
        Storage::disk('public')->delete($version->filename);
        dd($version);
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
