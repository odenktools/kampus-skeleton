<?php

use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiTableSeeder extends Seeder
{
    private $model;

    public function __construct()
    {
        $this->model = new Prodi;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->create([
            'nama_prodi' => 'Management informatika',
            'kode_prodi' => 'mi',
            'deskripsi' => 'Management Informatika adalah jurusan yang...',
        ])->id;
    }
}
