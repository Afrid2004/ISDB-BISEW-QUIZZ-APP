<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('options', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('question_id');

            $table->string('option_text', 255);

            $table->boolean('is_correct') ->default(false);

            $table->string('option_order', 45)->nullable();
            $table->timestamps();
            // Composite index
            $table->index(['question_id', 'is_correct']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
