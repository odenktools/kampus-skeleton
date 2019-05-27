<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * MataKuliahJurusan Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class MataKuliahJurusan extends Pivot
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matakuliah_jurusan';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}