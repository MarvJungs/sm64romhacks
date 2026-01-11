<?php

namespace App\Services;

use Google\Service\YouTube\Video;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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

    public function getVideo(string $videoid): ?Video
    {
        return $this->getVideos([$videoid])[$videoid] ?? null;
    }
}