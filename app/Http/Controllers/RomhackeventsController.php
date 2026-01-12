<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRomhackeventRequest;
use App\Http\Requests\UpdateRomhackeventRequest;
use App\Models\Romhackevent;
use App\Models\Run;
use App\Models\Video;
use App\Services\YoutubeService;
use Google\Service\YouTube\Thumbnail;
use Google\Service\YouTube\ThumbnailDetails;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;

class RomhackeventsController extends Controller
{
    public function index()
    {
        $events = Romhackevent::orderByDesc('start_utc')->get();
        return view('events.index', ['events' => $events]);
    }
    public function create()
    {
        return view('events.create');
    }

    public function edit(Romhackevent $event)
    {
        return view('events.edit', ['event' => $event]);
    }

    public function show(YoutubeService $youtubeService, Romhackevent $event)
    {
        if ($event->external) {
            return redirect($event->external_url);
        }
        $videodata = $event->runs->map(
            function (Run $run, int $key) {
                return $run->videos->map(
                    function (Video $video, int $key) {
                        $link = $video->link;
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match);
                        $videoid = $match[1];
                        return ['id' => $videoid, 'thumbnail' => $video->thumbnail];
                    }
                );
            }
        )->flatten(1)->toArray();

        $videos = $youtubeService->getVideos($videodata);
        return view('events.show', ['event' => $event, 'videos' => $videos]);
    }

    public function store(StoreRomhackeventRequest $request)
    {
        $r = $request->validated();
        $event = Romhackevent::create($r);
        return redirect(route('events.index'));
    }

    public function update(UpdateRomhackeventRequest $request, Romhackevent $event)
    {
        $r = $request->validated();
        $event->update($r);
        return redirect(route('events.index'));
    }

    public function destroy(Request $request, Romhackevent $event)
    {
        $event->delete();
        return view(route('events.index'));
    }
}
