<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('results')->nullable();
            $table->string('classes');
            $table->string('sections');
            $table->string('exam_name');
            $table->text('subjects')->nullable(); 
            $table->text('total_marks')->nullable();
            $table->text('obtained_marks')->nullable();
            $table->text('percentage')->nullable();
            $table->text('grade')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
};
