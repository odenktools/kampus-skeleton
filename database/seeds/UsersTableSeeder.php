<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $roleModel;
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\User;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->userModel->create([
            'name' => 'odenktools',
            'kampus_id' => 1,
            'email' => 'odenktools@kampus.odenktools.com',
            'phone' => '089670000000',
            'password' => bcrypt("odenktools"),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])->user_role()->attach([
            'role_id' => 1,
        ]);
    }
}
