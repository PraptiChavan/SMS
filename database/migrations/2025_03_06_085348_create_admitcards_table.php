<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admitcards', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->enum('fees_paid', ['Yes', 'No']);
            $table->string('admit_card')->nullable();
            $table->string('classes');
            $table->string('sections');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admitcards');
    }
};
