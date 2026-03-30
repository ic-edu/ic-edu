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
        Schema::create('subsections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();

            $table->string('title');
            $table->string('instructions')->nullable();
            $table->integer('order_position');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsections');
    }
};
