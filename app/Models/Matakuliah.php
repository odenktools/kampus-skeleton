<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Matakuliah Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class Matakuliah extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matakuliah';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_matakuliah', 'kode_matakuliah', 'sks', 'semester', 'deskripsi',
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
                'sks',
                'semester',
                'deskripsi'
            );
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jurusan()
    {
        return $this->belongsToMany('App\Models\Jurusan',
            'matakuliah_jurusan',
            'matakuliah_id', 'jurusan_id', 'id')
            ->using('App\Models\MataKuliahJurusan');
    }
}
