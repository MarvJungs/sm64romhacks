<?php

namespace App\Http\Controllers;

use App\Leaderboard;
use App\Models\Event;
use App\Models\LeagueCategory;
use App\Models\LeagueParticipant;
use App\PointsTable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class LeagueCategoryController extends Controller
{
    public function show(Event $event, LeagueCategory $leagueCategory)
    {
        list($category_id, $subcategory_id) = explode('+', $leagueCategory->src_category_id);
        $leaderboard = Http::get("https://www.speedrun.com/api/v1/leaderboards/$leagueCategory->src_game_id/category/$category_id?embed=players,variables&$subcategory_id")->json()['data'];
        dd($leaderboard);
        $points_leaderboard = $leagueCategory->leaguePointsTables;
        $points_leaderboard = $points_leaderboard->sortByDesc(function ($run) {
            return $run->points;
        });
        return view('leagueCategory.leaderboard', compact('points_leaderboard', 'leagueCategory'));
    }
}
