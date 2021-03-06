<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Kampus Migration.
 *
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
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
            $table->string('no_telephone', 150)->unique();
            $table->string('kota', 255)->comment('bandung,semarang,jakarta,yogyakarta,etc');
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
