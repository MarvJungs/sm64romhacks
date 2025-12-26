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
            'romhacks', function (Blueprint $table) {
                $table->uuid('id')->nullable(false)->unique();
                $table->string('name')->nullable(false)->unique();
                $table->string('slug')->nullable(false)->unique();
                $table->text('description')->nullable(true);
                $table->integer('starcount')->nullable(false)->default(0);
                $table->integer('difficulty')->nullable(false)->default(0);
                $table->integer('peak')->nullable(false)->default(0);
                $table->string('videolink')->nullable(true);
                $table->boolean('verified')->nullable(false)->default(false);
                $table->boolean('rejected')->nullable(false)->default(false);
                $table->boolean('archived')->nullable(false)->default(false);
                $table->boolean('megapack')->nullable(false)->default(false);
                $table->integer('views')->default(0);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('romhacks');
    }
};
