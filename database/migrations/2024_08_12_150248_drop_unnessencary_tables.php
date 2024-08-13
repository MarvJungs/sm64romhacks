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
        Schema::drop('hacks_authors');
        Schema::drop('hacks_tags');
        Schema::drop('authors_backup');
        Schema::drop('hacks_backup');
        Schema::drop('tags_backup');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
