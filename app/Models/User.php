<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Storage;

/**
 * User Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $table = 'users';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['kampus_id', 'name', 'email', 'phone', 'password', 'avatar', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar'
    ];

    /**
     * Casting data type.
     *
     * @var array
     */
    protected $casts = ['is_active' => 'boolean'];

    public function sql()
    {
        $image = new \App\Models\Image;
        return $this
            ->leftJoin($image->table, $image->table . '.id', '=', $this->table . '.avatar')
            ->select(
                $this->table . '.id',
                $this->table . '.name',
                $this->table . '.kampus_id',
                $this->table . '.phone',
                $this->table . '.email',
                $image->table . '.image as avatar',
                $this->table . '.email',
                $this->table . '.is_active'
            );
    }

    public function kampus()
    {
        return $this->belongsTo(\App\Models\Kampus::class, 'kampus_id', 'id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->getEmailForPasswordReset()));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(\App\Models\Image::class, 'avatar', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user_role()
    {
        return $this->belongsToMany('App\Models\Role',
            'user_roles',
            'user_id', 'role_id', 'id')
            ->using('\App\Models\UserRole');
    }

    /**
     * Get the image's full url.
     *
     * @return string
     */
    public function getAvatarAttribute()
    {
        return env('APP_URL') . Storage::url($this->attributes['avatar']);
    }

    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->orWhere('phone', $identifier)->orWhere('name', $identifier)->first();
    }
}
