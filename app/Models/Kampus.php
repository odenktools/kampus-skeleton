<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Events\KampusSaved;

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
    use Notifiable;

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
        'nama_kampus', 'kode_kampus', 'alamat', 'no_telephone', 'kota', 'deskripsi'
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The event map for the model. Buat class App\Events\KampusSaved
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => KampusSaved::class,
    ];

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
                'images.image_url',
                'kampus.created_at',
                'kampus.updated_at'
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

    /**
     * Ambil data users pada kampus.
     * <code>
     * $kampus = Kampus::find(1);
     * foreach ($kampus->users as $user) {
     * $user->user_role()->detach();
     * $user->delete();
     * }
     * </code>
     */
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'kampus_id', 'id');
    }
}
