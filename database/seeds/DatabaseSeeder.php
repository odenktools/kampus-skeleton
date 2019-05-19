<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(KampusTableSeeder::class);
        $this->call(ProdiTableSeeder::class);
        $this->call(JurusanTableSeeder::class);
    }
}
