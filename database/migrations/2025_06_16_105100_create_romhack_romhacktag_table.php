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
        Schema::create('romhack_romhacktag', function (Blueprint $table) {
            $table->id();
            $table->uuid('romhack_id');
            $table->unsignedBigInteger('romhacktag_id');
            $table->timestamps();

            $table->foreign('romhack_id')->references('id')->on('romhacks')->cascadeOnDelete();
            $table->foreign('romhacktag_id')->references('id')->on('romhacktags')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('romhack_romhacktag');
    }
};
