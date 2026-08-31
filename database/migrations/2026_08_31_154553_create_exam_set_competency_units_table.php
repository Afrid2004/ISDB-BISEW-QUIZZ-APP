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
        Schema::create('exam_set_competency_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_set_id')->constrained('exam_sets')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('competency_unit_id')->constrained('competency_units')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('question_count');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['exam_set_id', 'competency_unit_id'], 'unique_exam_set_competency_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_set_competency_units');
    }
};
