<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatakuliahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliah', function (Blueprint $table) {
            $table->bigIncrements('id');;
            $table->string('nama_matakuliah', 150)->unique();
            $table->string('kode_matakuliah', 15)->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->index('nama_matakuliah');
            $table->index('kode_matakuliah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matakuliah');
    }
}
