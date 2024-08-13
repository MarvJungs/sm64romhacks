<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    //     /**
    //      * Run the migrations.
    //      */
    public function up(): void
    {
        Schema::rename('author', 'authors_backup');

        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->uuid('version_id');
            $table->timestamps();
            $table->unique(['version_id', 'name']);
        });

        $hacks_authors = DB::table('hacks_authors')->get();

        $index = 0;
        foreach ($hacks_authors as $hack_author) {
            $hack_id = $hack_author->hack_id;
            $author_id = $hack_author->author_id;

            $hack_name = DB::table('hacks_backup')->where('hack_id', '=', $hack_id)->get(['hack_name', 'hack_version'])->first();
            $author_name = DB::table('authors_backup')->where('author_id', '=', $author_id)->pluck('author_name')->first();

            $hack_uuid = DB::table('hacks')->where('name', '=', $hack_name->hack_name)->pluck('id')->first();
            $version_uuid = DB::table('versions')->where(['hack_id' => $hack_uuid, 'name' => $hack_name->hack_version])->pluck('id');

            foreach ($version_uuid as $version_id) {
                try {
                    $index = $index + 1;
                    DB::table('authors')->insert([
                        'id' => ($index),
                        'name' => $author_name,
                        'version_id' => $version_id
                    ]);
                } catch (Throwable $th) {
                    // print($th->getMessage() . "\n");
                }
            }
        }
    }
};
