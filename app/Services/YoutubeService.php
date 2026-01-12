<?php

namespace App\Services;

use Google\Service\YouTube\Video;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class YoutubeService
{
    protected Google_Service_YouTube $google_Service_YouTube;
    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(config('services.google.api_key'));
        $this->google_Service_YouTube = new Google_Service_YouTube($client);
    }
    public function getVideos(array $videodata): array
    {
        $videos = [];
        foreach (array_chunk($videodata, 50) as $chunk) {
            $ids = Arr::pluck($chunk, 'id');
            $thumbnails = Arr::pluck($chunk, 'thumbnail');
            $queryParam = ['id' => Arr::join($ids, ',')];
            $response = $this->google_Service_YouTube->videos->listVideos('snippet,contentDetails,statistics', $queryParam);

            foreach ($response->getItems() as $index => $video) {
                $videos[$video->getId()] = $video;
                $videos[$video->getId()]->getSnippet()->getThumbnails()->getStandard()->setUrl(Storage::url($thumbnails[$index]));
            }
        }
        return $videos;
    }

    public function getVideoIDFromVideolink(string $videolink)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videolink, $match);
        $videoid = $match[1];
        return $videoid;
    }

    public function downloadVideoThumbnails(array $videoids, string $storagePath)
    {
        $thumbnails = [];
        foreach (array_chunk($videoids, 50) as $chunk) {
            $queryParam = ['id' => Arr::join($videoids, ',')];
            $response = $this->google_Service_YouTube->videos->listVideos('snippet,contentDetails,statistics', $queryParam);
            $videos = $response->getItems();

            foreach ($videos as $video) {
                $filename_prefix = Str::random();
                $filename_afterfix = $video->getId();
                $filename = "$filename_prefix" . "_$filename_afterfix.jpg";
                $thumbnail = Http::get($video->getSnippet()->getThumbnails()->getStandard()->getUrl());
                $fullFilepath = $storagePath . $filename;
                Storage::put($fullFilepath, $thumbnail->getBody());
                $thumbnails[$video->getId()] = $fullFilepath;
            }
        }
        return $thumbnails;
    }
}