<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('version_authors', function (Blueprint $table) {
            $table->unsignedBigInteger('author_id')->nullable(false)->default(0);
        });

        $version_authors = DB::table('version_authors')->get();

        foreach ($version_authors as $version_author) {
            $author_name = $version_author->name;
            $author_id = DB::table('authors')->select('id')->where(['name' => $author_name]);
            DB::table('version_authors')->where('name', '=', $author_name)->update([
                'author_id' => $author_id
            ]);
        }

        Schema::table('version_authors', function (Blueprint $table) {
            $table->dropIndex('authors_version_id_name_unique');
            $table->dropColumn('name');
            $table->rename('author_version');
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
