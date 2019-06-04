<?php

namespace App\Events;

use App\Models\Kampus;
use Illuminate\Queue\SerializesModels;

/**
 * KampusSaved.
 *
 * php artisan make:observer KampusObserver --model=Kampus
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 * @docs       https://laravel.com/docs/5.8/eloquent#events
 */
class KampusSaved
{
    use SerializesModels;

    public $kampus;

    public $additionalArray;

    /**
     * Create a new event instance. Kemudian buat listener untuk event ini di \App\Listeners\KampusNotification.
     *
     * @param \App\Models\Kampus $kampus
     * @return void
     */
    public function __construct(Kampus $kampus, array $additionalArray = [])
    {
        $this->kampus = $kampus;
        $this->additionalArray = $additionalArray;
    }
}