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
        Schema::table('league_categories', function (Blueprint $table) {
            $table->dropColumn('category_url');
            $table->dropColumn('category_name');

            $table->string('src_game_id')->after('hack_id');
            $table->string('src_category_id')->after('src_game_id');
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
