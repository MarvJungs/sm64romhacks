<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('authors', 'version_authors');
        $version_authors_table = DB::table('version_authors')->get();

        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
        });

        $index = 1;
        foreach ($version_authors_table as $version_author) {
            try {
                DB::table('authors')->insert([
                    'id' => $index,
                    'name' => $version_author->name,
                ]);
                $index++;
            } catch (\Throwable $th) {
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
