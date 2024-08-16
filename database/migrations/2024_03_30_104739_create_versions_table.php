<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
//     /**
//      * Run the migrations.
//      */
    public function up(): void
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->uuid('id')->primary()->nullable(false);
            $table->uuid('hack_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->integer('starcount')->default(0)->nullable(false);
            $table->date('releasedate')->default('9999-12-31')->nullable(false);
            $table->integer('downloadcount')->default(0)->nullable(false);
            $table->string('filename')->nullable(false);
            $table->boolean('recommend')->default(false)->nullable(false);
            $table->boolean('demo')->default(false)->nullable(false);
            $table->timestamps();
            $table->unique(['hack_id','name']);
        });

        $distincthackNames = DB::table('hacks_backup')->distinct()->pluck('hack_name');

        foreach ($distincthackNames as $i => $hackName) {
            $hack_id = DB::table('hacks')->where('name', $hackName)->pluck('id')->first();

            $versions = DB::table('hacks_backup')->where('hack_name', $hackName)->get();

            foreach ($versions as $j => $version) {
                try {
                    DB::table('versions')->insert([
                        'id' => Str::uuid(),
                        'hack_id' => $hack_id,
                        'name' => $version->hack_version,
                        'starcount' => $version->hack_starcount,
                        'releasedate' => $version->hack_release_date,
                        'downloadcount' => $version->hack_downloads,
                        'filename' => 'patch/' . $version->hack_patchname . '.zip',
                        'recommend' => $version->hack_recommend,
                        'demo' => $version->hack_demo,
                        'created_at' => date('Y-m-d h:i:s', Storage::lastModified('patch/' . $version->hack_patchname . '.zip')),
                        'updated_at' => date('Y-m-d h:i:s', Storage::lastModified('patch/' . $version->hack_patchname . '.zip'))
                    ]);
                } catch (\Throwable $th) {
                    print($th->getMessage() . "\n");
                }
            }
        }
    }
};
