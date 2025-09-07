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
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('course')->nullable();;
            $table->string('exam_result')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_details')->nullable();
            $table->decimal('gwa', 5, 2)->nullable();
            $table->string('school')->nullable();
            $table->string('strand')->nullable();

            // Ratings
            $table->tinyInteger('rating_communication')->nullable();
            $table->tinyInteger('rating_confidence')->nullable();
            $table->tinyInteger('rating_thinking')->nullable();

            // Overall Rating
            $table->decimal('interview_result', 4, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
    }
};
