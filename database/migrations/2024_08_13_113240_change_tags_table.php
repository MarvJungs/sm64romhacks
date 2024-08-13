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
        Schema::rename('tags', 'hack_tag');
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->unique();
            $table->timestamps();
        });

        Schema::table('hack_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id')->nullable(false)->default(0);
        });

        $hack_tags = DB::table('hack_tag')->get();
        $index = 1;
        foreach ($hack_tags as $hack_tag) {
            try {
                DB::table('tags')->insert([
                   'id' => $index,
                   'name' => $hack_tag->name,
                   'created_at' => now(),
                   'updated_at' => now()
                ]);
                DB::table('hack_tag')->where('name', '=', $hack_tag->name)->update([
                    'tag_id' => $index
                ]);
                $index++;
            } catch (\Throwable $th) {
                // print($th->getMessage() . "\n");
            }
        }

        Schema::table('hack_tag', function (Blueprint $table) {
            $table->dropForeign('tags_hack_id_foreign');
            $table->dropUnique('tags_hack_id_name_unique');
            $table->dropColumn('name');
            $table->foreign('hack_id')->references('id')->on('hacks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
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
