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

        Schema::rename('tags', 'tags_backup');

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->uuid('hack_id');
            $table->string('name');
            $table->unique(['hack_id', 'name']);
        });

        $tags = DB::table('hacks_tags')->get();

        foreach ($tags as $index => $tag) {
            $hack_name = DB::table('hacks_backup')->where('hack_id', $tag->hack_id)->pluck('hack_name')->first();
            $tag_name = DB::table('tags_backup')->where('tag_id', $tag->tag_id)->pluck('tag_name')->first();

            $hack_uuid = DB::table('hacks')->where('name', $hack_name)->pluck('id')->first();
            if ($tag_name != '') {
                try {
                    DB::table('tags')->insert([
                        'id' => ($index + 1),
                        'hack_id' => $hack_uuid,
                        'name' => $tag_name
                    ]);
                } catch (\Throwable $th) {
                    // print($th->getMessage() . "\n");
                }
            }
        }
    }
};
