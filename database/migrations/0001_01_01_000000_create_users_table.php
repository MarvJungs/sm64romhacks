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

        Schema::drop('news');
        Schema::drop('users');

        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('created_at');
        //     $table->dropColumn('twitch_handle');
        //     $table->collation = 'utf8mb4_unicode_ci';

        //     DB::table('users')->where('discord_id', 0)->delete();
        // });

        // Schema::table('users', function (Blueprint $table) {

        //     $table->unsignedBigInteger('discord_id')->nullable(false)->change();
        //     $table->renameColumn('discord_id', 'id');

        //     $table->string('discord_username')->nullable(false)->change();
        //     $table->renameColumn('discord_username', 'display_name');

        //     $table->renameColumn('discord_email', 'email');
        //     $table->string('discord_email')->nullable(false)->change();

        //     $table->renameColumn('discord_avatar', 'avatar');
        //     $table->string('discord_avatar')->nullable(false)->change();
        // });

        Schema::create('users', function (Blueprint $table) {
            $table->string('email')->nullable(false);
            $table->string('display_name')->nullable(false);
            $table->unsignedBigInteger('id')->nullable(false)->primary(true);
            $table->string('avatar')->nullable(false);
            $table->string('user_name')->nullable(false);
            $table->string('token')->nullable(false);
            $table->string('refreshToken')->nullable(false);
            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->unsignedBigInteger('author_id')->nullable(true);
            $table->string('country')->nullable(true);
            $table->string('gender')->nullable(true);
            $table->boolean('notify')->nullable(false)->default(false);
            $table->timestamps();
        });

        DB::table('users')->where('role_id', 0)->delete();

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
