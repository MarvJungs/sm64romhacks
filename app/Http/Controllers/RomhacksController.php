<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRomhackRequest;
use App\Http\Requests\UpdateRomhackRequest;
use App\Models\Author;
use App\Models\Image;
use App\Models\Romhack;
use App\Models\Romhacktag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class RomhacksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hacks = Romhack::with(['versions.authors', 'romhacktags'])->orderBy('name')->get();
        $tags = Romhacktag::all()->sortBy('name');
        return view(
            'hacks.index',
            [
                'hacks' => $hacks,
                'tags' => $tags
            ]
        );
    }

    public function create()
    {
        $tags = Romhacktag::all()->sortBy('name');
        $authors = Author::all()->sortBy('name');

        return view(
            'hacks.create',
            [
                'authors' => $authors,
                'tags' => $tags
            ]
        );
    }

    /**
     * Show the form for creating or editing a resource.
     */
    public function edit(Romhack $hack)
    {
        $tags = Romhacktag::all()->sortBy('name');
        $authors = Author::all()->sortBy('name');

        return view(
            'hacks.edit',
            [
                'authors' => $authors,
                'hack' => $hack,
                'tags' => $tags
            ]
        );
    }

    public function store(StoreRomhackRequest $request)
    {
        $data = $request->safe()->collect()->get('romhack');
        $romhack = Romhack::firstOrCreate(
            ['name' => $data['name']],
            collect($data)->except('name')->toArray()
        );
        
        $data['version']['filename'] = $request->file('romhack.version.patchfile')->store('patch', 'public');
        $version = $romhack->versions()->create($data['version']);
        foreach ($data['version']['author']['name'] as $name) {
            $author = Author::firstOrCreate(['name' => $name]);
            $version->authors()->save($author);
        }

        if (Arr::has($data, 'tag')) {
            foreach ($data['tag']['name'] as $tag) {
                $romhacktag = Romhacktag::firstOrCreate(['name' => $tag]);
                $romhack->romhacktags()->attach($romhacktag);
            }
        }

        return redirect(route('hack.show', ['hack' => $romhack]));
    }

    /**
     * Store a newly created or updated resource in storage.
     */
    public function update(UpdateRomhackRequest $request, Romhack $hack)
    {
        $images = $request->file('romhack.image');
        foreach ($images as $image) {
            $hack->images()->create(['filename' => $image->store("images/hacks/{$hack->id}", 'public')]);
        }
        $data = $request->safe()->collect()->get('romhack');
        $hack->update($data);
        $hack->romhacktags()->detach();


        if (Arr::has($data, 'tag')) {
            foreach ($data['tag']['name'] as $tag) {
                $romhacktag = Romhacktag::firstOrCreate(['name' => $tag]);
                $hack->romhacktags()->attach($romhacktag);
            }
        }
        return redirect(route('hack.show', ['hack' => $hack]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Romhack $hack)
    {
        $CrawlerDetect = new CrawlerDetect();
        if (!$CrawlerDetect->isCrawler()) {
            $hack->increment('views');
        }
        return view('hacks.view')->with('hack', $hack);
    }

    public function random()
    {
        $hack = Romhack::all()->random();
        return $this->show($hack);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Romhack $hack)
    {   
        foreach ($hack->versions as $version) {
            Storage::disk('public')->delete($version->filename);
        }

        foreach ($hack->images as $image) {
            Storage::delete($image->filename);
            $image->delete();
        }
        
        $hack->delete();
        return redirect(route('hack.index'));
    }

    public function modhub()
    {
        $pendingHacks = Romhack::with(['versions.authors.user', 'romhacktags'])->where('verified', '=', 0, 'and', 'rejected', '=', 0)->orderBy('name')->get();
        return view('hacks.modhub', ['hacks' => $pendingHacks]);
    }

    public function verify(Romhack $hack)
    {
        $hack->update(
            [
            'verified' => 1,
            'rejected' => 0
            ]
        );
        return redirect(route('modhub.hacks.index'))->with('info', 'The Romhack has successfully been verified');
    }

    public function reject(Romhack $hack)
    {
        $hack->update(
            [
                'verified' => 0,
                'rejected' => 1
            ]
        );
        return redirect(route('modhub.hacks.index'))->with('info', 'The Romhack has successfully been rejected!');
    }
}
