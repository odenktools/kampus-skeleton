<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurusan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('kampus_prodi_id');
            $table->string('nama_jurusan', 100)->unique();
            $table->string('kode_jurusan', 15)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->index('nama_jurusan');
            $table->index('kode_jurusan');
            $table->foreign('kampus_prodi_id')->references('id')
                ->on('kampus_prodi_many');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurusan');
    }
}
