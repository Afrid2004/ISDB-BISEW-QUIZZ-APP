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
        Schema::create('exam_sets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_id')
                ->constrained('exams')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('name', 100);

            $table->enum('type', [
                'mid',
                'monthly',
            ]);

            $table->enum('question_type', [
                'mcq',
                'evidence',
            ]);

            $table->enum('mode', [
                'online',
                'offline',
            ]);

            $table->enum('status', [
                'draft',
                'published',
                'processing',
                'completed',
                'cancelled',
            ])->default('draft');

            $table->unsignedTinyInteger('set_number');

            $table->unsignedInteger('duration_minutes')->nullable();

            $table->decimal('total_marks', 8, 2)->default(0.00);

            $table->decimal('pass_marks', 8, 2)->default(0.00);

            $table->decimal('weight_percentage', 5, 2)->default(0.00);

            $table->boolean('shuffle_questions')->default(true);

            $table->boolean('shuffle_options')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['exam_id', 'type', 'set_number'],
                'unique_exam_set'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_sets');
    }
};