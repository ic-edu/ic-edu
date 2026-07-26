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
        Schema::create('question_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subsection_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->text('instruction')->nullable();
            $table->string('group_type')->nullable();

            $table->text('passage_text')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('image_path')->nullable();

            $table->integer('order_position');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_groups');
    }
};
