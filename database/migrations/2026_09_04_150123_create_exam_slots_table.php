<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('batch_id')
                ->constrained('batches')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('exam_set_id')
                ->constrained('exam_sets')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_slots');
    }
};
