<?php

namespace App;

use App\Models\LeagueCategory;
use App\Models\LeaguePointsPerSecond;

class PointsTable
{
    protected $leagueCategory;
    protected $oldRun;
    protected $newRun;
    public function __construct(LeagueCategory $leagueCategory, Run|null $oldRun, Run $newRun)
    {
        $this->leagueCategory = $leagueCategory;
        $this->oldRun = $oldRun;
        $this->newRun = $newRun;
    }

    public function getPoints()
    {
        switch ($this->leagueCategory->league->leaguePointsSystem->id) {
            case 1:
                return $this->calculatePoints($this->newRun->getTime()) - $this->calculatePoints($this->oldRun?->getTime()) + $this->getBonus();
            case 2:
                return $this->calculatePoints($this->newRun->getTime()) + $this->getBonus();
            case 3:
                return 0;
            default:
                return 0;
        }
    }

    private function calculatePoints(int|null $time): int
    {
        switch ($this->leagueCategory->league->leaguePointsSystem->id) {
            case 1:
                $cutoffs = $this->leagueCategory->leaguePointsPerSeconds->sortBy('tier');
                $points = 0;
                if ($time > $cutoffs->first()->cutoff_t || is_null($time)) {
                    return 0;
                }

                $currentCutoff_t = $cutoffs->first()->cutoff_t;
                $remainingSeconds_t = $currentCutoff_t - $time;
                $cutoffs->each(function (LeaguePointsPerSecond $item, int $key) use (&$currentCutoff_t, &$remainingSeconds_t, &$points, $time) {
                    $possible_seconds = $currentCutoff_t - $item->cutoff_t;
                    if ($currentCutoff_t > $time && $item->cutoff_t < $time) {
                        $points += ($currentCutoff_t - ($currentCutoff_t - abs($remainingSeconds_t))) * $item->points_per_second;
                        return false;
                    } elseif ($time < $item->cutoff_t) {
                        $points += $possible_seconds * $item->points_per_second;
                        $remainingSeconds_t -= $possible_seconds;
                    }
                    $currentCutoff_t = $item->cutoff_t;
                });
                return $points;
            case 2:
                $totalPossiblePoints = (104 - 10) * 1 + 5 * 2 + 5 * 3;
                $subtractor = 0;
                if ($this->newRun->getPlace() - 1 > 10) {
                    $subtractor = 5 * 3 + 5 * 2 + ($this->newRun->getPlace() - 1 - 10) * 1;
                } elseif ($this->newRun->getPlace() - 1 > 5) {
                    $subtractor = 5 * 3 + ($this->newRun->getPlace() - 1 - 5) * 2;
                } else {
                    $subtractor = ($this->newRun->getPlace() - 1) * 3;
                }
                return $totalPossiblePoints - $subtractor;
            case 3:
                return 0;
            default:
                return 0;
        }
    }

    private function getBonus(): int
    {
        return $this->leagueCategory->bonus_points;
    }
}
