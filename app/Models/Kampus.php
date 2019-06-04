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
