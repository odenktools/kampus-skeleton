<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * MatakuliahJurusan Migration.
 *
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class CreateMatakuliahJurusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matakuliah_jurusan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('matakuliah_id');
            $table->unsignedBigInteger('jurusan_id');
            $table->timestamps();
            $table->foreign('matakuliah_id')->references('id')
                ->on('matakuliah');
            $table->foreign('jurusan_id')->references('id')
                ->on('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matakuliah_jurusan');
    }
}
