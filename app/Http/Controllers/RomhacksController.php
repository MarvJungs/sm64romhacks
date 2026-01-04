<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRomhackRequest;
use App\Http\Requests\UpdateRomhackRequest;
use App\Models\Author;
use App\Models\Romhack;
use App\Models\Romhacktag;
use Google\Service\YouTube\Video;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Illuminate\Support\Facades\Http;

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
        if ($images !== null) {
            foreach ($images as $image) {
                $hack->images()->create(['filename' => $image->store("images/hacks/{$hack->id}", 'public')]);
            }
        }
        $data = $request->safe()->collect()->get('romhack');
        $hack->update($data);
        $hack->romhacktags()->detach();

        $videolink = Arr::get($data, 'videolink');
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videolink, $match);
        $videoid = $match[1];
        $this->downloadYoutubeThumbnail($hack, $videoid);

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
        $videoid = null;
        if (!$CrawlerDetect->isCrawler()) {
            $hack->increment('views');
        }

        if ($hack->videolink !== null) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $hack->videolink, $match);
            $videoid = $match[1];
        }
        return view('hacks.view', ['hack' => $hack, 'videoid' => $videoid]);
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

    private function downloadYoutubeThumbnail(Romhack $hack, string $videoid)
    {
        $client = new Google_Client();
        $client->setDeveloperKey(config('services.google.api_key'));
        $service = new Google_Service_YouTube($client);
        $queryParam = ['id' => $videoid];
        $response = $service->videos->listVideos('snippet,contentDetails,statistics', $queryParam);
        $videos = $response->getItems();
        if (count($videos) > 0) {
            $video = $videos[0];
            $thumbnail = Http::get($video->getSnippet()->getThumbnails()->getStandard()->getUrl());
            Storage::put("images/hacks/{$hack->id}/videoThumbnail.jpg", $thumbnail->getBody());
        }
    }
}
