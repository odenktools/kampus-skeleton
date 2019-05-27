<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Kampus;
use App\Repositories\EloquentKampusRepository;

class KampusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanCreateData()
    {
        $data = [
            'nama_kampus' => $this->faker->word,
            'kode_kampus' => $this->faker->word,
            'no_telephone' => $this->faker->phone,
            'alamat' => $this->faker->url,
            'deskripsi' => $this->faker->word,
        ];
        $repo = new EloquentKampusRepository(new Kampus);
        $kampus = $repo->create($data);
    }
}
