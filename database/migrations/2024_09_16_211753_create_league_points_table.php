<?php

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
        Schema::create('league_points_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('league_category_id');
            $table->unsignedBigInteger('league_participant_id');
            $table->string('personal_best');
            $table->integer('points');
            $table->timestamps();

            $table->foreign('league_category_id')->references('id')->on('league_categories');
            $table->foreign('league_participant_id')->references('id')->on('league_participants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_points');
    }
};
