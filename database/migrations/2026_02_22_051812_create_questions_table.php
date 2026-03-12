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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_group_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type');
            $table->longText('question_text')->nullable();

            $table->string('image_path')->nullable();
            $table->string('audio_path')->nullable();

            $table->integer('points')->default(1);

            $table->integer('order_position');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
