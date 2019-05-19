<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKampusManyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('kampus_prodi_many', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kampus_id');
            $table->unsignedBigInteger('prodi_id');
            $table->timestamps();

            $table->foreign('kampus_id')->references('id')
                ->on('kampus');

            $table->foreign('prodi_id')->references('id')
                ->on('prodi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('kampus_prodi_many');
    }
}
