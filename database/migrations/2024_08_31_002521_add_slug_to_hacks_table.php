<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Hack;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hacks', function (Blueprint $table) {
            $table->string('slug')->after('name');
        });

        $hacks = Hack::all();

        foreach ($hacks as $hack) {
            $hack->update([
                'slug' => Str::slug($hack->name),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hacks', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
