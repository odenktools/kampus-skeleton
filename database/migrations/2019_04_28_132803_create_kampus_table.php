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
            $table->bigIncrements('id');
            $table->string('nama_kampus', 200)->unique();
            $table->string('kode_kampus', 220)->unique();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->string('no_telephone', 150)->unique();
            $table->longText('alamat');
            $table->longText('deskripsi')->nullable();
            $table->timestamps();
            $table->index('kode_kampus');
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
