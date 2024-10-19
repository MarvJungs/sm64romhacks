<?php

namespace App\View\Components\League\Leaderboard;

use App\Leaderboard;
use App\Models\Event;
use App\Models\LeagueCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ByImprovement extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $pointsLeaderboard,
        public LeagueCategory $leagueCategory
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.league.leaderboard.byImprovement');
    }
}
