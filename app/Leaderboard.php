<?php

namespace App;

use App\Models\LeagueCategory;
use App\Models\LeagueParticipant;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Leaderboard
{
    protected $leaderboard;
    protected $startDate;
    protected $leagueCategory;
    public function __construct(LeagueCategory $leagueCategory, string $startTime = null, string $endTime = null)
    {
        if (!is_null($startTime)) {
            $startDate = Carbon::createFromTimeString($startTime, 'UTC')->format('Y-m-d');
        } else {
            $startDate = $startTime;
        }

        if (!is_null($endTime)) {
            $endDate = Carbon::createFromTimeString($endTime, 'UTC');
            $endDate = $endDate->addDay()->format('Y-m-d');
            $response = Http::get("$leagueCategory->api_url&date=$endDate");
        } else {
            $response = Http::get($leagueCategory->api_url);
        }

        if (!$response->successful()) {
            dd($response->json());
        }

        $leaderboard = $response->json()['data'];

        $this->leaderboard = $leaderboard;
        $this->startDate = $startDate;
        $this->leagueCategory = $leagueCategory;
    }

    public function getWeblink(): string
    {
        return $this->leaderboard['weblink'];
    }

    public function getGameName(): string
    {
        return $this->leaderboard['game']['data']['names']['international'];
    }

    public function getCategoryName(): string
    {
        return $this->leaderboard['category']['data']['name'];
    }

    public function getVariables(): array
    {
        return $this->leaderboard['variables']['data'];
    }

    public function getRunsByPlacement(): Collection
    {
        $runs = $this->leaderboard['runs'];
        $runsCollection = new Collection();
        foreach ($runs as $index => $run) {
            $runsCollection->put($index, new Run($run, $this->leagueCategory));
        }
        if (!is_null($this->startDate)) {
            $runsCollection = $runsCollection->filter(function ($run) {
                return $run->getDate() >= $this->startDate;
            })->values();
        }

        return $runsCollection;
    }

    public function getRunsByRunner(): Collection
    {
        $runs = $this->leaderboard['runs'];
        $runsCollection = new Collection();
        foreach ($runs as $index => $run) {
            $runEntity = new Run($run, $this->leagueCategory);
            $runsCollection->put($this->getPlayers()->get($runEntity->getPlace() - 1)->getName(), $runEntity);
        }
        if (!is_null($this->startDate)) {
            $runsCollection = $runsCollection->filter(function ($run) {
                return $run->getDate() >= $this->startDate;
            });
        }
        return $runsCollection;
    }

    public function getPlayers(): Collection
    {
        $players = $this->leaderboard['players']['data'];
        $playersCollection = new Collection();
        foreach ($players as $player) {
            $playersCollection->push(new Player($player));
        }
        return $playersCollection;
    }
}
