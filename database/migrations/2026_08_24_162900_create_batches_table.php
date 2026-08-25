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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('training_center_id');
            $table->unsignedBigInteger('shift_id');

            // Batch Details
            $table->string('batch_number', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->unsignedInteger('max_students')->default(50);
            $table->boolean('is_active')->default(true);

            // Soft Deletes & Timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
