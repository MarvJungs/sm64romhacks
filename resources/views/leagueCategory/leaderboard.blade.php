<x-layout>
    <h2>Game Leaderboard</h2>
    <h3>{{ $leagueCategory->hack->name }} - {{ $leagueCategory->category_name }}</h3>
    @switch($leagueCategory->league->leaguePointsSystem->id)
        @case(1)
            <x-league.leaderboard.byImprovement :pointsLeaderboard="$points_leaderboard" :leagueCategory="$leagueCategory" />
        @break

        @case(2)
            <x-league.leaderboard.leaderboardByPlace :pointsLeaderboard="$points_leaderboard" :leagueCategory="$leagueCategory" />
        @break

        @case(3)
            <x-league.leaderboard.byImprovement :pointsLeaderboard="$points_leaderboard" :leagueCategory="$leagueCategory" />
            <x-league.leaderboard.leaderboardByPlace :pointsLeaderboard="$points_leaderboard" :leagueCategory="$leagueCategory" />
        @break

        @default
    @endswitch
</x-layout>
