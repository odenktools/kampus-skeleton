<?php

use Illuminate\Database\Seeder;
use App\Models\Kampus;

class KampusTableSeeder extends Seeder
{
    private $model;

    public function __construct()
    {
        $this->model = new Kampus;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->create([
            'nama_kampus' => 'LPKIA',
            'kode_kampus' => 'lpkia-jaya',
            'image_id' => 1,
            'deskripsi' => 'Kampus tercinta LPKIA Jaya',
        ])->id;
    }
}
