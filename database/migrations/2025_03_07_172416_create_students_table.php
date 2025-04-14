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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('address');
            $table->bigInteger('contact_number');
            $table->string('school');
            $table->string('strand');
            $table->integer('age');
            $table->integer('exam')->nullable();
            $table->integer('interview')->nullable();
            $table->integer('skill_test')->nullable();
            $table->integer('gwa')->nullable();
            $table->integer('total')->nullable();
            $table->string('student_course')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
