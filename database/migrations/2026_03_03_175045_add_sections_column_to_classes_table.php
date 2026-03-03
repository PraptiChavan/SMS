<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionsColumnToClassesTableV2 extends Migration
{
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->text('sections')->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('sections');
        });
    }
}