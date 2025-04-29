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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Float with 5 digits total and 2 decimal places, and nullable
            $table->float('exam', 5, 2)->nullable();
            $table->float('interview', 5, 2)->nullable();
            $table->float('gwa', 5, 2)->nullable();
            $table->float('skill_test', 5, 2)->nullable();
            $table->string('remarks')->nullable(); // Passed / Failed
            $table->string('course')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
