<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    //     /**
    //      * Run the migrations.
    //      */
    public function up(): void
    {
        $hacks = DB::table('hacks')->get();

        Schema::rename('hacks', 'hacks_backup');


        Schema::create('hacks', function (Blueprint $table) {
            $table->uuid('id')->primary()->nullable(false);
            $table->string('name')->unique()->nullable(false)->index();
            $table->text('description')->nullable(true);
            $table->float('difficulty')->default(0.00)->nullable(false);
            $table->float('peak')->default(0.00)->nullable(false);
            $table->boolean('megapack')->default(false)->nullable(false);
            $table->boolean('verified')->default(false)->nullable(false)->index();
            $table->boolean('rejected')->default(false)->nullable(false);
            $table->timestamps();
        });


        foreach ($hacks as $hack) {
            try {
                DB::table('hacks')->insert([
                    [
                        'id' => Str::uuid(),
                        'name' => $hack->hack_name,
                        'megapack' => $hack->hack_megapack,
                        'verified' => true
                    ]
                ]);
            } catch (\Throwable $th) {
                // print($th->getMessage() . "\n");
            }
        }
    }

    //     /**
    //      * Reverse the migrations.
    //      */
    //     public function down(): void
    //     {
    //         Schema::dropIfExists('hacks');
    //     }
};
