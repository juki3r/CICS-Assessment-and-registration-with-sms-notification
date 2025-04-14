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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Logs which user did the task
            $table->string('firstname');
            $table->string('lastname');
            $table->string('name_of_student');
            $table->string('activity');
            $table->string('status')->default('unread');
            $table->string('task');       // e.g., "added student", "edited info"
            $table->string('course');     // e.g., "BSIT", "BSCS"
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
