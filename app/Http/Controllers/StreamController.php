<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class StreamController extends Controller
{
    private array $whitelist_titles = ['romhack', 'rom hack'];
    private array $whitelist_tags = ['romhack', 'rom hack', 'hack', 'modded', 'mod'];
    public function index()
    {
        SEOMeta::setTitle('Streams');

        OpenGraph::setTitle('Streams');
        OpenGraph::setDescription('Overview of Ongoing Livestreams related to SM64 ROM Hacks');
        OpenGraph::setType('Streams');
        
        return view('streams/index', ['streams' => $this->filterStreams($this->getStreams())]);
    }

    private function getEndPoint()
    {
        $endPoint = "game_id=2692&first=100";
        return "https://api.twitch.tv/helix/streams?" . $endPoint;
    }

    private function getTwitchAuthorization()
    {
        $endPoint = " ";
        $data = "client_id=" . env('TWITCH_CLIENT_ID') . "&client_secret=" . env('TWITCH_CLIENT_SECRET') . "&grant_type=client_credentials";
        $link = "https://id.twitch.tv/oauth2/token?" . $data;

        // Request cURL POST pour get le token
        $ch = curl_init($link);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        curl_close($ch);

        // Decode
        $token = json_decode($res);
        return $token;
    }

    private function getStreams()
    {
        $endPoint = $this->getEndPoint();
        $authorizationObject = $this->getTwitchAuthorization();
        $authorizationObject = json_decode(json_encode($authorizationObject), true);
        $access_token = $authorizationObject["access_token"];
        $expires_in = $authorizationObject["expires_in"];
        $token_type = $authorizationObject["token_type"];

        $token_type = strtoupper(substr($token_type, 0, 1)) . substr($token_type, 1, strlen($token_type));

        $authorization = $token_type . " " . $access_token;
        $header = array("Authorization: " . $authorization, "Client-ID: " . env('TWITCH_CLIENT_ID'));

        $ch = curl_init($endPoint);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $res = curl_exec($ch);
        curl_close($ch);

        // Decode
        $data =  json_decode($res);

        return $data->data;
    }

    private function filterStreams($streams)
    {
        return array_filter($streams, function ($stream) {
            return in_array(strtolower($stream->title), $this->whitelist_titles) || $this->validateTags($stream->tags);
        });
    }

    private function validateTags($tags)
    {
        $flag = false;

        $tags = array_map(fn ($value): string => strtolower($value), $tags);
        foreach ($this->whitelist_tags as $whiteElement) {
            if (in_array($whiteElement, $tags)) {
                $flag = true;
            }
        }
        return $flag;
    }
}
