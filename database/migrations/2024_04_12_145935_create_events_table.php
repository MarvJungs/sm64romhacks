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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable(false);
            $table->string('horaro_id')->nullable(true);
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(true);
            $table->dateTime('start_utc')->nullable(true);
            $table->dateTime('end_utc')->nullable(true);
            $table->boolean('marathon')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
