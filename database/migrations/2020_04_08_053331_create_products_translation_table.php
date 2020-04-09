<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_translation', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('product_id')->unsigned()->index();;
            $table->integer('language_id')->unsigned()->index();

            $table->softDeletes();

            $table->string('name');
            $table->text('tag');
            $table->string('grade');
            $table->string('type');
            $table->string('school_services');
            $table->string('student_services');
            $table->text('description');
            $table->json('facts')->nullable();
            $table->json('features')->nullable();
            $table->string('brochure')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_translation');
    }
}
