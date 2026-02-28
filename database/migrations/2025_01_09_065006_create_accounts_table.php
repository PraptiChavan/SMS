<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('accounts')) {
            Schema::create('accounts', function (Blueprint $table) {
                $table->id();
                $table->string('type')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('password')->notNullable();
                // $table->unsignedBigInteger('student_id')->nullable()->after('password'); // Ensure it's nullable
                $table->unsignedBigInteger('student_id')->nullable();
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}

