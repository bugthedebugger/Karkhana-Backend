<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->json('data')->nullable();
            $table->integer('section_id')->unsigned()->index();
            $table->integer('language_id')->unsigned()->index();

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections_translations');
    }
}
