<?php

namespace App\Repositories;

use App\Contracts\KampusRepository;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class EloquentKampusRepository
 *
 * Ini Class Encapsulasi agar model dapat dipanggil dari luar package
 * Note : Tambahkan fungsi disini...
 *
 *
 * Langkah Ke-3 :
 * @see \App\Providers\MemberServiceProvider::registerFacades()
 *
 *
 * @package App\Repositories
 * @version    1.0.0
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class EloquentKampusRepository implements KampusRepository
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * Model yang akan digunakan.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Application $app, \App\Models\Kampus $model)
    {
        $this->app = $app;
        $this->model = $model;
    }

    /**
     * Dynamic copy `method-method` pada `Model` yang dituju,
     * tujuannya agar class ini tidak menambahkan secara
     * terus menerus `method-method` yang terdapat pada `Model`.
     *
     * method ini tidak perlu dipanggil dimanapun, karena otomatis
     * saat class ini terpanggil method jalan dengan sendiri-nya
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (is_callable(array($this->model, $method))) {
            return call_user_func_array([$this->model, $method], $parameters);
        } else {
            return false;
        }
    }
}
