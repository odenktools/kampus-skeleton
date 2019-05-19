<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKampusImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampus_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kampus_id');
            $table->unsignedBigInteger('image_id');
            $table->timestamps();
            $table->foreign('kampus_id')->references('id')
                ->on('kampus');
            $table->foreign('image_id')->references('id')
                ->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kampus_image');
    }
}
