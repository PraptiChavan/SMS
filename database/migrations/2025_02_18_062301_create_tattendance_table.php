<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tattendance', function (Blueprint $table) {
            $table->id();
            // Foreign Key for teacher
            $table->foreignId('teacher_id')->constrained('accounts')->onDelete('cascade'); // Foreign key linking to teachers
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['P', 'A']);
            $table->timestamps();

            // Unique constraint to avoid duplicate entries for the same student on the same date
            $table->unique(['teacher_id', 'date', 'period_id']); // Avoid duplicate entries
        });
    }

    public function down()
    {
        Schema::dropIfExists('tattendance');
    }
};
