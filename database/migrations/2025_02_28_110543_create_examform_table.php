<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('examform', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Subject name
            $table->string('classes');       // Classes (stored as a string)
            $table->string('subjects');       // Classes (stored as a string)
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('total_marks');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('examform');
    }
};
