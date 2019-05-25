<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    private $roleModel;

    public function __construct()
    {
        $this->roleModel = new \App\Models\Role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->roleModel->create([
            'name' => 'Admin',
            'description' => 'Grup Admin',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->roleModel->create([
            'name' => 'Dosen',
            'description' => 'Grup Dosen',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
