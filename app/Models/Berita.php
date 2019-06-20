<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Berita Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class Berita extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'berita';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul_berita', 'tipe_berita', 'isi_berita', 'thumbnail', 'post_date', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'thumbnail',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'post_date'
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Casting data type.
     *
     * @var array
     */
    protected $casts = ['is_active' => 'boolean'];

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
            ->leftJoin('images', 'images.id', '=', 'berita.thumbnail')
            ->select(
                'berita.id',
                'judul_berita',
                'tipe_berita',
                'isi_berita',
                'images.image_url',
                'post_date',
                'is_active'
            );
    }

    /**
     * Convert PostDate to ISO8601.
     *
     * @return string
     */
    public function getPostDateAttribute()
    {
        $date = new \Carbon\Carbon($this->attributes['post_date']);
        $date->setTimezone('Asia/Jakarta');
        return $date->toIso8601String();
    }

    public function images()
    {
        return $this->belongsTo(\App\Models\Image::class, 'thumbnail', 'id');
    }
}
