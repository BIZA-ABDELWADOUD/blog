<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title',70)->nullable();
            $table->text('post')->nullable();
            $table->text('jsonData')->nullable();
            $table->string('post_excerpt',300);
            $table->string('slug')->unique()->nullable();
            $table->Integer('user_id');
            $table->string('featuredImage')->nullable();
            $table->text('metaDescription')->nullable();
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('blogs');
    }
}
