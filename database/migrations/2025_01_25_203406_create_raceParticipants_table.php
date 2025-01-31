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
        Schema::create('race_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('event_id')->references('id')->on('events');
            $table->integer('sr1PB');
            $table->integer('sr2PB');
            $table->integer('sr3PB');
            $table->integer('sr4PB');
            $table->integer('sr5PB');
            $table->integer('sr6PB');
            $table->integer('sr7PB');
            $table->integer('sr8PB');
            $table->boolean('accept_rules');
            $table->unique(['user_id', 'event_id']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_participants');
    }
};
