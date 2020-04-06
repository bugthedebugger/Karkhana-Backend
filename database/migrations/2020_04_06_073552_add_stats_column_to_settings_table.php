<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatsColumnToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('students_reached')->nullable();
            $table->string('employees')->nullable();
            $table->string('countried_we_work_in')->nullable();
            $table->string('cities_we_work_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('students_reached');
            $table->dropColumn('employees');
            $table->dropColumn('countried_we_work_in');
            $table->dropColumn('cities_we_work_in');
        });
    }
}
