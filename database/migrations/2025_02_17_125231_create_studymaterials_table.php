<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('studymaterials', function (Blueprint $table) {
            $table->id();
            $table->string('title');          // Subject name
            $table->string('attachment')->nullable(); // Image (path to the image)
            $table->string('classes');       // Classes (stored as a string)
            $table->string('subjects');       // Classes (stored as a string)
            $table->date('date');
            $table->string('description'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('studymaterials');
    }
};
