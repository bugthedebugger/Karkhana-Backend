<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHasGuestAuthorToBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign('blogs_author_foreign');
            $table->dropIndex('blogs_author_index');
            $table->bigInteger('author')->unsigned()->index()->nullable()->change();  
            $table->foreign('author')->references('id')->on('users')->onDelete('cascade');          
        });
        

        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('has_guest_author')->default(false);
            $table->bigInteger('guest_id')->unsigned()->index()->nullable();
            $table->foreign('guest_id')->references('id')->on('guest_author')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            Schema::disableForeignKeyConstraints();
            $table->bigInteger('author')->change();
            $table->dropColumn('has_guest_author');
            $table->dropColumn('guest_id');
            Schema::enableForeignKeyConstraints();
        });
    }
}
