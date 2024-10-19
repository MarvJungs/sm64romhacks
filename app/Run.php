<?php

namespace App;

use App\Models\LeagueCategory;

class Run
{
    protected $run;
    protected $leagueCategory;
    protected $placement;
    public function __construct(array $run, LeagueCategory $leagueCategory)
    {
        $this->run = $run;
        $this->leagueCategory = $leagueCategory;
        $this->placement = $this->run['place'];
    }

    public function getPlace(): int
    {
        return $this->placement;
    }

    public function getTime(): int
    {
        return $this->run['run']['times']['primary_t'];
    }

    public function getDate(): string|null
    {
        return $this->run['run']['date'];
    }

    public function setPlace(int $place): void
    {
        $this->placement = $place;
    }

    public function format(): string
    {
        $hours = floor($this->getTime() / 3600);
        $minutes = str_pad(floor($this->getTime() / 60) % 60, 2, '0', STR_PAD_LEFT);
        $seconds = str_pad(floor($this->getTime() % 60), 2, '0', STR_PAD_LEFT);
        return "$hours:$minutes:$seconds";
    }
}
