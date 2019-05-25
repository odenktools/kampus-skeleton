<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->bigIncrements('id');;
            $table->string('judul_berita', 150)->unique();
            $table->string('tipe_berita', 50)->comment('sport,hiburan,politik,pendidikan');
            $table->longText('isi_berita');
            $table->dateTime('post_date');
            $table->unsignedBigInteger('thumbnail')->nullable();
            $table->integer('is_active')->default(0);
            $table->index('judul_berita');
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
        Schema::dropIfExists('berita');
    }
}
