<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * KampusProdiMany Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class KampusProdiMany extends Pivot
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kampus_prodi_many';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

}