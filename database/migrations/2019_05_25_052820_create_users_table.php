<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Users Migration.
 *
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kampus_id');
            $table->string('name', 150)->unique()->index();
            $table->string('email', 150)->unique()->index();
            $table->string('phone')->unique()->index();
            $table->string('password');
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null)->comment('token untuk access mobile api');
            $table->unsignedBigInteger('avatar')->nullable();
            $table->integer('is_active')->default(1)->comment('0 = Not Active, 1 = Active');
            $table->rememberToken();
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->ipAddress('last_logout_ip')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->timestamps();
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
        Schema::drop('password_resets');
        Schema::drop('users');
    }
}
