<?php

use Database\Seeders\LeaguePointsSystemSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('league_points_systems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        (new LeaguePointsSystemSeeder())->run();

        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('league_points_system_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('league_points_system_id')->references('id')->on('league_points_systems');
            $table->timestamps();
        });

        Schema::create('league_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('league_id');
            $table->integer('bonus_points');
            $table->string('category_url');
            $table->string('hack_id');
            $table->string('category_name');
            $table->timestamps();
            $table->foreign('league_id')->references('id')->on('leagues');
            $table->foreign('hack_id')->references('id')->on('hacks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
