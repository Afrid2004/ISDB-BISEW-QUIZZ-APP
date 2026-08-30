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
        Schema::create('competency_units', function (Blueprint $table) {
            $table->id();

            $table->foreignId('module_id')
                ->constrained('modules')
                ->cascadeOnDelete();

            $table->string('prefix', 10)->default('STC');

            $table->unsignedInteger('serial');

            $table->string('code', 50)->unique();

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // Same module-এর মধ্যে serial unique হবে
            $table->unique(['module_id', 'serial']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competency_units');
    }
};
