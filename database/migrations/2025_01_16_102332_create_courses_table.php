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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');        // Course name
            $table->string('category');    // Course category
            $table->string('duration');    // Duration (e.g., 3 months, 6 weeks)
            $table->date('date');          // Date (e.g., start date)
            $table->string('image')->nullable(); // Image (path to the image)
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
