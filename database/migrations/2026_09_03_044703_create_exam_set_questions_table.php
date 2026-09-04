<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_set_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_set_id')
                ->constrained('exam_sets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->constrained('questions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedInteger('question_order');

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['exam_set_id', 'question_id'],
                'unique_exam_set_question'
            );

            $table->unique(
                ['exam_set_id', 'question_order'],
                'unique_exam_set_question_order'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_set_questions');
    }
};
