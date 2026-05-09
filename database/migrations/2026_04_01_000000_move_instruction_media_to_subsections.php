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
        // First drop from sections
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn(['instruction_audio_path', 'instruction_image_path']);
        });

        // Add to subsections
        Schema::table('subsections', function (Blueprint $table) {
            $table->string('instruction_audio_path')->nullable()->after('instructions');
            $table->string('instruction_image_path')->nullable()->after('instruction_audio_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subsections', function (Blueprint $table) {
            $table->dropColumn(['instruction_audio_path', 'instruction_image_path']);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->string('instruction_audio_path')->nullable()->after('description');
            $table->string('instruction_image_path')->nullable()->after('instruction_audio_path');
        });
    }
};
