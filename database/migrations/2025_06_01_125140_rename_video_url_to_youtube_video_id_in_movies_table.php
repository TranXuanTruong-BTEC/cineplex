<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->renameColumn('video_url', 'youtube_video_id');
            $table->string('youtube_video_id', 50)->change(); // Change to string with limited length
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->renameColumn('youtube_video_id', 'video_url');
            $table->string('video_url')->change(); // Revert to original string type
        });
    }
};
