<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Dosen Migration.
 *
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 150)->unique();
            $table->string('kode_dosen', 15)->unique();
            $table->string('nidn', 100)->unique()->comment('Nomor Dosen (NIDN)');
            $table->string('jenis_kelamin', 10)->comment('laki-laki,perempuan');
            $table->string('email', 150)->unique();
            $table->string('phone', 15)->unique();
            $table->string('password');
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null)->comment('token untuk access mobile api');
            $table->unsignedBigInteger('avatar')->nullable();
            $table->string('status_dosen', 50)->comment('tetap,luarbiasa');
            $table->text('alamat')->nullable();
            $table->rememberToken();
            $table->string('fcm_token')->nullable()->comment('Token used for push notification');
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->ipAddress('last_logout_ip')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('nama');
            $table->index('email');
            $table->index('nidn');
            $table->index('kode_dosen');
            $table->index('status_dosen');
            $table->index('phone');
            $table->foreign('avatar')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dosen');
    }
}
