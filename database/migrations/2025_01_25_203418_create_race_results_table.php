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
        Schema::create('race_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');
            $table->integer('sr1Time');
            $table->integer('sr2Time');
            $table->integer('sr3Time');
            $table->integer('sr4Time');
            $table->integer('sr5Time');
            $table->integer('sr6Time');
            $table->integer('sr7Time');
            $table->integer('sr8Time');
            $table->integer('totalStars');
            $table->timestamps();

            $table->unique(['user_id', 'event_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_results');
    }
};
