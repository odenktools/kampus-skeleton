<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Berita Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools Technology
 */
class Berita extends Model
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
        'judul_berita', 'tipe_berita', 'isi_berita', 'thumbnail', 'post_date', 'is_active'
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
                'judul_berita',
                'tipe_berita',
                'isi_berita',
                'thumbnail',
                'post_date',
                'is_active',
            )->with('images');
    }

    public function images()
    {
        return $this->belongsTo(\App\Models\Image::class, 'thumbnail', 'id');
    }
}
