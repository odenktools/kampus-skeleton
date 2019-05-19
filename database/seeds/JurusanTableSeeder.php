<?php

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanTableSeeder extends Seeder
{
    private $model;

    public function __construct()
    {
        $this->model = new Jurusan;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->create([
            'kampus_prodi_id' => 1,
            'nama_jurusan' => 'Manajement Informatika',
            'kode_jurusan' => 'mi',
            'deskripsi' => 'Jurusan manajement informatika merupakan...',
        ])->id;

        $this->model->create([
            'kampus_prodi_id' => 1,
            'nama_jurusan' => 'Teknik Informatika',
            'kode_jurusan' => 'ti',
            'deskripsi' => 'Jurusan Teknik Informatika merupakan...',
        ])->id;
    }
}
