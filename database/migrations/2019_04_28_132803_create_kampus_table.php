<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKampusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kampus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kampus', 200)->unique();
            $table->string('kode_kampus', 220)->unique();
            $table->integer('image_id')->nullable()->unsigned();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->index('kode_kampus');
            $table->foreign('image')->references('id')
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
        Schema::dropIfExists('kampus');
    }
}
