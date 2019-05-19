<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Jurusan Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools Technology
 */
class Jurusan extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jurusan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_jurusan', 'nama_jurusan', 'deskripsi', 'kampus_prodi_id'
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    /**
     * Declare sql method for custom query.
     *
     * @return string
     */
    public function sql()
    {
        return $this
            ->select(
                'nama_matakuliah',
                'kode_matakuliah',
                'deskripsi'
            );
    }
}
