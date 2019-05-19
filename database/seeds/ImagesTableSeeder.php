<?php

use Illuminate\Database\Seeder;
use App\Models\Image;

class ImagesTableSeeder extends Seeder
{
    private $model;

    public function __construct()
    {
        $this->model = new Image;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model->create([
            'image_url' => 'images/kampus/lpkia.png',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ])->id;
    }
}
