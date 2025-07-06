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
            'author_version', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('author_id');
                $table->uuid('version_id');
                $table->timestamps();

                $table->foreign('author_id')->references('id')->on('authors')->cascadeOnDelete();
                $table->foreign('version_id')->references('id')->on('versions')->cascadeOnDelete();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_version');
    }
};
