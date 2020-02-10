<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeColumnsOfTranslationTabelOptional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs_translation', function (Blueprint $table) {
            $table->longText('body')->nullable()->change();
            $table->integer('read_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs_translation', function (Blueprint $table) {
            $table->longText('body')->change();
            $table->integer('read_time')->change();
        });
    }
}
