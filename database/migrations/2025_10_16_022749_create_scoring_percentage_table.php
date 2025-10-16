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
        Schema::create('scoring_percentage', function (Blueprint $table) {
            $table->id();
            $table->decimal('interview', 5, 2)->default(0.20);
            $table->decimal('gwa', 5, 2)->default(0.30);
            $table->decimal('skilltest', 5, 2)->default(0.25);
            $table->decimal('exam', 5, 2)->default(0.25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scoring_percentage');
    }
};
