<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('tokens')->default(0)->after('profile_bio');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedInteger('tokens_required')->default(1)->after('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tokens');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn('tokens_required');
        });
    }
};
