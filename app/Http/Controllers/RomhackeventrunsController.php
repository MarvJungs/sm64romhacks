<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRomhackeventrunRequest;
use App\Http\Requests\UpdateRomhackeventrunRequest;
use App\Models\Romhack;
use App\Models\Romhackevent;
use App\Models\Run;
use App\Models\Video;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RomhackeventrunsController extends Controller
{
    public function create(Romhackevent $event)
    {
        $hacks = Romhack::all()->sortBy('name');
        return view('events.runs.create', ['event' => $event, 'hacks' => $hacks]);
    }

    public function store(StoreRomhackeventrunRequest $request, Romhackevent $event)
    {
        $romhack = Arr::get($request, 'romhack');
        $category = Arr::get($request, 'category');
        $videolinks = Arr::get($request, 'videolink');
        $run = $event->runs()->firstOrCreate(
            [
                'romhack' => $romhack,
                'category' => $category
            ]
        );
        foreach ($videolinks as $videolink) {
            $run->videos()->firstOrCreate(
                [
                    'link' => $videolink,
                    'thumbnail' => $this->downloadYoutubeThumbnail($videolink)
                ]
            );
        }
        return redirect(route('events.index'));
    }

    public function edit(Romhackevent $event, Run $run)
    {
        $hacks = Romhack::all()->sortBy('name');
        return view('events.runs.edit', ['hacks' => $hacks, 'run' => $run]);
    }

    public function update(UpdateRomhackeventrunRequest $request, Romhackevent $event, Run $run)
    {
        $r = $request->validated();

        $run->update(
            [
                'romhack' => $r['romhack'],
                'category' => $r['category'],
                'type' => $r['type']
            ]
        );

        $run->videos()->each(
            function (Video $video) {
                Storage::delete($video->thumbnail);
                $video->delete();
            }
        );

        foreach ($r['videolink'] as $videolink) {
            $run->videos()->createOrFirst(
                [
                    'link' => $videolink,
                    'thumbnail' => $this->downloadYoutubeThumbnail($videolink)
                ]
            );
        }
        return redirect(route('events.index'));
    }

    public function destroy(Romhackevent $event, Run $run)
    {
        $run->videos()->each(
            function (Video $video) {
                Storage::delete($video->thumbnail);
                $video->delete();
            }
        );
        $run->delete();
        return redirect(route('events.index'));
    }

    private function downloadYoutubeThumbnail(string $videolink)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videolink, $match);
        $videoid = $match[1];

        $client = new Google_Client();
        $client->setDeveloperKey(config('services.google.api_key'));
        $service = new Google_Service_YouTube($client);
        $queryParam = ['id' => $videoid];
        $response = $service->videos->listVideos('snippet,contentDetails,statistics', $queryParam);
        $videos = $response->getItems();
        if (count($videos) > 0) {
            $video = $videos[0];
            $filename_prefix = Str::random();
            $filename_afterfix = $video->getId();
            $filename = "$filename_prefix" . "_$filename_afterfix";
            $thumbnail = Http::get($video->getSnippet()->getThumbnails()->getStandard()->getUrl());
            $storagePath = "events/thumbnails/$filename.jpg";
            Storage::put($storagePath, $thumbnail->getBody());
            return $storagePath;
        }
    }
}
