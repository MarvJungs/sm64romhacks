<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Hack;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hacks = Hack::all();
        foreach ($hacks as $hack) {
            $versions = $hack->versions->sortBy('created_at');

            $hack->update([
                'created_at' => $versions->first()?->created_at,
                'updated_at' => $versions->last()?->created_at
            ]);
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
