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
        Schema::create('league_points_per_seconds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('league_category_id');
            $table->string('cutoff');
            $table->integer('points_per_second');
            $table->integer('tier');
            $table->foreign('league_category_id')->references('id')->on('league_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('league_points_per_seconds');
    }
};
