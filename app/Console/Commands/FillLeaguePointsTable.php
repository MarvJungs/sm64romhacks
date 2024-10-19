<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\LeagueCategory;
use App\PointsTable;
use Illuminate\Console\Command;
use App\Leaderboard;
use App\Models\LeagueParticipant;
use Illuminate\Support\Collection;

class FillLeaguePointsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'league-points-table:fill {event}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills the league points table with data';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $event = Event:: where(['slug' => $this->argument('event')])->get()->first();
        foreach ($event->league->leagueCategories as $leagueCategory) {
            $leagueCategory->leaguePointsTables()->delete();
            $pointsTable = $this->getPointsTable($event, $leagueCategory);
            $pointsTable->each(function ($record) use ($leagueCategory) {
                $league_participant_id = LeagueParticipant::where([
                    'display_name' => $record->get('runner')->getName(),
                    'league_id' => $leagueCategory->league->id
                    ])->pluck('id')->first();
                $leagueCategory->leaguePointsTables()->create([
                    'league_participant_id' => $league_participant_id,
                    'personal_best' => $record->get('newRun')->format(),
                    'points' => $record->get('points')
                ]);
            });
        }
    }

    private function getPointsTable(Event $event, LeagueCategory $leagueCategory): Collection
    {
        $new_leaderboard = new Leaderboard($leagueCategory, $event->start_utc, $event->end_utc);
        $old_leaderboard = new Leaderboard($leagueCategory, null, $event->start_utc);
        $points_leaderboard = new Collection();
        $league_participants = LeagueParticipant::where(['league_id' => $leagueCategory->league->id])->get()->pluck('display_name');
        foreach ($new_leaderboard->getRunsByPlacement() as $rank => $run) {
            $placement = $rank + 1;
            $runner = $new_leaderboard->getPlayers()->get($run->getPlace() - 1);
            $oldRun = $old_leaderboard->getRunsByRunner()->get($new_leaderboard->getPlayers()->get($run->getPlace() - 1)?->getName());
            $newRun = $new_leaderboard->getRunsByPlacement()->get($rank);
            $points = (new PointsTable($leagueCategory, $oldRun, $newRun))->getPoints();
            $leaderboardData = new Collection([
                'placement' => $placement,
                'runner' => $runner,
                'oldRun' => $oldRun,
                'newRun' => $newRun,
                'points' => $points
            ]);
            $points_leaderboard->push($leaderboardData);
        }
        $points_leaderboard = $points_leaderboard->filter(function ($record) use ($league_participants) {
            $runnerName = strtolower($record->get('runner')?->getName());
            return $league_participants->contains($runnerName);
        })->values();

        $points_leaderboard = $points_leaderboard->each(function (Collection $record, int $index) use ($leagueCategory) {
            $record->put('placement', $index + 1);
            $record->get('newRun')->setPlace($index + 1);
            $record->put('points', (new PointsTable($leagueCategory, $record->get('oldRun'), $record->get('newRun')))->getPoints());
        });
        return $points_leaderboard;
    }
}
