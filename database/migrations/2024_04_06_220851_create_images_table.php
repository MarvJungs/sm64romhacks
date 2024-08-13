<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 return new class extends Migration
 {
//     /**
//      * Run the migrations.
//      */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->uuid('hack_id');
            $table->string('filename');
            $table->timestamps();
        });
    }
 };
