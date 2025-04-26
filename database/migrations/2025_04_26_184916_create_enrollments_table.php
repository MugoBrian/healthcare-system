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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('health_program_id')->constrained()->onDelete('cascade');
            $table->date('enrollment_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'completed', 'withdrawn'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Prevent duplicate enrollments
            $table->unique(['client_id', 'health_program_id', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
