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
        Schema::create(
            'versions', function (Blueprint $table) {
                $table->uuid('id')->primary(true)->nullable(false)->unique();
                $table->foreignUuid('romhack_id')->constrained()->cascadeOnDelete();
                $table->string('name')->nullable(false);
                $table->integer('starcount')->nullable(false)->default(0);
                $table->date('releasedate')->nullable(false)->default(now());
                $table->integer('downloadcount')->nullable(false)->default(0);
                $table->string('filename')->nullable(false);
                $table->boolean('recommened')->nullable(false)->default(false);
                $table->boolean('demo')->nullable(false)->default(false);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versions');
    }
};
