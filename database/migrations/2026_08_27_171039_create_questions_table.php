<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->nullable();
            $table->string('module_code')->nullable();
            $table->string('module_name')->nullable();
            $table->string('unit_code')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('element_id')->nullable();
            $table->text('question_text');
            $table->string('question_type')->default('mcq');
            $table->decimal('marks', 8, 2)->default(1.00);
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');
            $table->text('explanation')->nullable();
            $table->string('created_by', 123)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
