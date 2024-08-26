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
        Schema::table('author_version', function (Blueprint $table) {
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('hack_id')->references('id')->on('hacks')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('disruptions', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->foreign('hack_id')->references('id')->on('hacks')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('hack_id')->references('id')->on('hacks')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('versions', function (Blueprint $table) {
            $table->foreign('hack_id')->references('id')->on('hacks')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
