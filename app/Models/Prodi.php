<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Prodi Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class Prodi extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prodi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_prodi', 'kode_prodi', 'deskripsi',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Hidden from fetch column.
     *
     * @var array
     */
    protected $hidden = ['pivot'];

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
                'nama_prodi',
                'kode_prodi',
                'deskripsi'
            );
    }
}
