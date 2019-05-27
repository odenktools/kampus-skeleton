<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Kampus Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class Kampus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kampus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_kampus', 'kode_kampus', 'alamat', 'no_telephone', 'kota' ,'deskripsi'
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
            ->leftJoin('kampus_image', 'kampus_image.kampus_id', '=', 'kampus.id')
            ->leftJoin('images', 'images.id', '=', 'kampus_image.image_id')
            ->select(
                'kampus.id',
                'kampus.nama_kampus',
                'kampus.kode_kampus',
                'kampus.no_telephone',
                'kampus.alamat',
                'kampus.deskripsi',
                'images.image_url'
            )->with('kampus_prodi');
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kampus_images()
    {
        return $this->belongsToMany('App\Models\Image', 'kampus_image',
            'kampus_id', 'image_id', 'id')
            ->using('App\Models\KampusImage');
    }

    /**
     * Define a many-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function kampus_prodi()
    {
        return $this->belongsToMany('App\Models\Prodi',
            'kampus_prodi_many',
            'kampus_id', 'prodi_id', 'id')
            ->using('App\Models\KampusProdiMany');
    }
}
