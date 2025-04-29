<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('parents_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('class_id');
            $table->date('date');
            $table->time('time');
            $table->enum('mode', ['Online', 'Offline']);
            $table->text('agenda');
            $table->enum('status', ['Pending', 'Accepted', 'Declined', 'Rescheduled'])->default('Pending');
            $table->string('meeting_link')->nullable();
            $table->unsignedBigInteger('status_updated_by')->nullable();

            $table->timestamps();
    
            $table->foreign('teacher_id')->references('id')->on('accounts')->where('type', 'teacher');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('status_updated_by')->references('id')->on('accounts'); // ✅ Foreign key
        });
    }

    public function down() {
        Schema::dropIfExists('parents_meetings');
        $table->unsignedBigInteger('status_updated_by')->nullable(false)->change();
    }
};

