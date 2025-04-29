<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('time', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('classes');       // Class IDs (stored as CSV string)
            $table->string('sections')->nullable(); // Section IDs (stored as CSV string, nullable)
            $table->string('periods');         // Period time
            $table->string('subjects');      // Subject IDs (stored as CSV string)
            $table->string('teachers');      // Teacher IDs (stored as CSV string)
            $table->string('weekdays');      // Weekday IDs (stored as CSV string)
            $table->timestamps();            // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('time'); // Drops the table
    }
};
