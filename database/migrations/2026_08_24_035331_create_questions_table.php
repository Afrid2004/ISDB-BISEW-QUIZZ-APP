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

            // // Relationships
            // $table->foreignId('course_id')
            //     ->constrained('courses')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();

            // $table->foreignId('module_id')
            //     ->constrained('modules')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();

            // $table->foreignId('competency_unit_id')
            //     ->constrained('competency_units')
            //     ->cascadeOnUpdate()
            //     ->restrictOnDelete();

            // // Question
            // $table->text('question_text');

            // // Options
            // $table->string('option_a');
            // $table->string('option_b');
            // $table->string('option_c')->nullable();
            // $table->string('option_d')->nullable();

            // // Correct Answer
            // $table->json('correct_answer');

            // // Marks
            // $table->decimal('marks', 8, 2)
            //     ->default(2.00);

            // // Difficulty
            // $table->enum('difficulty_level', [
            //     'easy',
            //     'medium',
            //     'hard',
            // ])->default('medium');

            // // Question Type
            // $table->enum('question_type', [
            //     'single_choice',
            //     'multiple_choice',
            // ])->default('single_choice');

            // // Status
            // $table->boolean('is_active')
            //     ->default(true);

            // // Creator
            // $table->foreignId('created_by')
            //     ->nullable()
            //     ->constrained('users')
            //     ->cascadeOnUpdate()
            //     ->nullOnDelete();

            // // Soft Delete
            // $table->softDeletes();
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
