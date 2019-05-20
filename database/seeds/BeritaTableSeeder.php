<?php

use Illuminate\Database\Seeder;
use App\Models\Berita;

class BeritaTableSeeder extends Seeder
{
    private $model;

    public function __construct()
    {
        $this->model = new Berita;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->create([
            'judul_berita' => 'Wow Mahasiswa LPKIA Mendapatkan Juara Olimpiade Teknologi',
            'tipe_berita' => 'pendidikan',
            'isi_berita' => 'Wow mahasiswa LPKIA mendapatkan juara olimpiade teknologi pada hari kamis 09 September 2019 yang diselengarakan oleh...',
            'post_date' => date('Y-m-d'),
            'thumbnail' => 1,
            'is_active' => 1,
        ])->id;
    }
}
