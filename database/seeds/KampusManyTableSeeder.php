<?php

use Illuminate\Database\Seeder;

class KampusManyTableSeeder extends Seeder
{
    public function __construct()
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kampus_prodi_many')->insertGetId([
            'id' => 1,
            'kampus_id' => 1,
            'prodi_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
