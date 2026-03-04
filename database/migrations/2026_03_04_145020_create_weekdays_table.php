<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekdays', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        // Insert default weekdays
        DB::table('weekdays')->insert([
            ['title' => 'Monday'],
            ['title' => 'Tuesday'],
            ['title' => 'Wednesday'],
            ['title' => 'Thursday'],
            ['title' => 'Friday'],
            ['title' => 'Saturday'],
            ['title' => 'Sunday'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('weekdays');
    }
};
