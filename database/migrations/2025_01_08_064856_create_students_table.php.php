<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->date('dob');
                $table->string('mobile')->nullable();
                $table->string('email')->unique();
                $table->string('address')->nullable();
                $table->string('country')->nullable();
                $table->string('state')->nullable();
                $table->string('zip')->nullable();
                $table->string('father_name')->nullable();
                $table->string('father_mobile')->nullable();
                $table->string('father_email')->unique();
                $table->string('mother_name')->nullable();
                $table->string('mother_mobile')->nullable();
                $table->string('mother_email')->unique();
                $table->string('parents_address')->nullable();
                $table->string('parents_country')->nullable();
                $table->string('parents_state')->nullable();
                $table->string('parents_zip')->nullable();
                $table->string('school_name')->nullable();
                $table->string('previous_class')->nullable();
                $table->string('status')->nullable();
                $table->string('total_marks')->nullable();
                $table->string('obtain_marks')->nullable();
                $table->string('previous_percentage')->nullable();
                $table->string('classes')->nullable();
                $table->string('sections')->nullable();
                $table->string('stream')->nullable();
                $table->date('doa')->nullable();
                $table->enum('payment_method', ['Online', 'Offline'])->default('Offline');
                $table->string('receipt_number')->nullable();
                $table->string('registration_fee')->nullable();
                $table->timestamps();
    
                // Foreign key linking to accounts table
                // $table->foreign('id')->references('id')->on('accounts')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

