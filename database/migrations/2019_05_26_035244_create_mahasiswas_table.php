<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Mahasiswa Migration.
 *
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kampus_id');
            $table->string('nama_mahasiswa', 150)->unique();
            $table->string('kode_mahasiswa', 15)->unique();
            $table->string('nrp', 100)->unique();
            $table->string('jenis_kelamin', 10)->comment('laki-laki,perempuan');
            $table->string('phone', 15)->unique();
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null)->comment('token untuk access mobile api');
            $table->string('golongan_darah', 3)->comment('A,B,AB,O');
            $table->string('tempat_lahir', 255)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tahun_masuk', 5)->nullable()->comment('tahun masuk mahasiswa');
            $table->date('tanggal_lulus')->nullable()->comment('tanggal kelulusan mahasiswa');
            $table->integer('semester_masuk')->default(1)->comment('semester berapa mahasiswa masuk');
            $table->string('agama')->comment('islam,kristen,katholik,buddha,hindu,kong_hu_chu');
            $table->string('status_menikah', 10)->comment('lajang,menikah,duda,janda');
            $table->text('alamat')->nullable();
            $table->string('warganegara', 3)->nullable()->comment('WNA,WNI');
            $table->string('keluarga_nama_ayah', 150)->nullable();
            $table->string('keluarga_nama_ibu', 150)->nullable();
            $table->text('keluarga_alamat')->nullable();
            $table->string('keluarga_phone', 15)->nullable();
            $table->string('keluarga_pekerjaan_ayah')->nullable();
            $table->string('keluarga_pekerjaan_ibu')->nullable();
            $table->string('sekolah_nama')->nullable()->comment('nama sekolah asal');
            $table->string('sekolah_lulusan_tahun')->nullable()->comment('tahun lulusan sekolah');
            $table->string('sekolah_jurusan')->nullable()->comment('ipa,ips,smk,madrasah');
            $table->integer('sekolah_passing_grade')->default(0)->comment('Nilai passing grade');
            $table->text('sekolah_alamat')->nullable()->comment('Alamat sekolah');
            $table->unsignedBigInteger('avatar')->nullable();
            $table->string('fcm_token')->nullable()->comment('Token used for push notification');
            $table->rememberToken();
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->ipAddress('last_logout_ip')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('nama_mahasiswa');
            $table->index('kode_mahasiswa');
            $table->index('phone');
            $table->index('email');
            $table->index('sekolah_passing_grade');
            $table->foreign('kampus_id')->references('id')->on('kampus');
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
        Schema::drop('mahasiswa');
    }
}
