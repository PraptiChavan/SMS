<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            // Foreign key linking to accounts table
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade')->after('student_id');
            $table->date('date');
            $table->enum('status', ['P', 'A']);
            $table->timestamps();

            // Unique constraint to avoid duplicate entries for the same student on the same date
            $table->unique(['student_id', 'date', 'period_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance');
    }
};
