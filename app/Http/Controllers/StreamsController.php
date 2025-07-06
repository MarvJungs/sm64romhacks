<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StreamsController extends Controller
{
    private array $_whitelist_titles = ['romhack', 'rom hack', 'hack'];
    private array $_whitelist_tags = ['romhack', 'rom hack', 'hack', 'modded', 'mod'];

    public function index()
    {
        $streams = $this->getStreams();
        $filteredStreams = $this->filterStreams($streams->data);

        return view('streams.index', ['streams' => $filteredStreams]);
    }
    
    private function getTwitchAuthorization()
    {
        $tokenEndpointParams = "client_id=" . env("TWITCH_CLIENT_ID") . "&client_secret=" . env("TWITCH_CLIENT_SECRET") . "&grant_type=client_credentials";
        $tokenEndpoint = "https://id.twitch.tv/oauth2/token?$tokenEndpointParams";
        return Http::post($tokenEndpoint)->object();
    }
    
    private function getStreams()
    {
        $streamsEndpointParams = [
            "game_id" => "2692",
            "first" => "100"
        ];
        $streamsEndpoint = "https://api.twitch.tv/helix/streams";
        $authorizationObject = $this->getTwitchAuthorization();
        $token_type = Str::ucfirst($authorizationObject->token_type);
        $authorization = $token_type . " " . $authorizationObject->access_token;
        $headers = ["Authorization" => $authorization, 'Client-Id' => env('TWITCH_CLIENT_ID')];
        $data = Http::withHeaders($headers)->get($streamsEndpoint, $streamsEndpointParams);
        if ($data->successful()) {
            $streamsUnfiltered = $data->object();
            return $streamsUnfiltered;
        } else {
            return null;
        }
    }

    private function filterStreams($streams): array
    {
        return Arr::reject($streams, fn ($stream) => !$this->validateTags($stream->tags) && !$this->validateTitle($stream->title));
    }

    private function validateTags($tags): bool
    {
        $tags = Arr::map($tags, fn ($value): string => Str::lower($value));

        foreach ($this->_whitelist_tags as $whitelistedElement) {
            if (in_array($whitelistedElement, $tags)) {
                return true;
            }
        }
        return false;
    }

    private function validateTitle($title): bool
    {
        $streamTitle = strtolower($title);
        foreach ($this->_whitelist_titles as $whitelistedElement) {
            if (str_contains($streamTitle, $whitelistedElement)) {
                return true;
            }
        }
        return false;
    }
}
