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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'created_at',
        'updated_at'
    ];

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
                'deskripsi',
                'created_at',
                'updated_at'
            );
    }

    /**
     * Convert PostDate to ISO8601.
     *
     * @return string
     */
    public function getCreatedAtAttribute()
    {
        $date = new \Carbon\Carbon($this->attributes['created_at']);
        $date->setTimezone('Asia/Jakarta');
        return $date->toIso8601String();
    }

    /**
     * Convert PostDate to ISO8601.
     *
     * @return string
     */
    public function getUpdatedAtAttribute()
    {
        $date = new \Carbon\Carbon($this->attributes['updated_at']);
        $date->setTimezone('Asia/Jakarta');
        return $date->toIso8601String();
    }
}
