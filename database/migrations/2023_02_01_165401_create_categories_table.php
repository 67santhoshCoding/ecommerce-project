<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('parent_id')->default(0);
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('meta_title')->nullable();
            $table->integer('meta_description')->nullable();
            $table->integer('meta_keyword')->nullable();
            $table->enum( 'is_featured', ['Yes','No'])->default("No");
            $table->integer('order_by')->nullable();
            $table->enum('status',['published','unpublished'])->default('published');
            $table->softDeletes();
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
        Schema::dropIfExists('categories');
    }
}
