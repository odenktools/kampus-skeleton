<?php

namespace App;

use App\Contracts\KampusRepository;

/**
 * KampusApp.
 *
 * @package App
 * @version    1.0.0
 * @author     Odenktools
 * @license    MIT
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class KampusApp
{
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * KampusRepository.
     *
     * @var \App\Contracts\KampusRepository
     */
    public $kampusRepository;

    /**
     * Constructor.
     */
    public function __construct($app, KampusRepository $kampusRepository)
    {
        $this->app = $app;
        $this->kampusRepository = $kampusRepository;
    }

    /**
     * Calling `KampusRepository` From This Class
     *
     * <code>
     * $data = KampusApp::kampus()->get();
     * echo json_encode($data);
     * </code>
     *
     * @see \App\Providers\KampusServiceProvider::registerFacades()
     * @return \App\Repositories\EloquentKampusRepository
     */
    public function kampus()
    {
        return $this->app['kampus.repokampus'];
    }
}
