<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UserRole Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class UserRole extends Model
{
    public $table = 'user_role';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['user_id', 'role_id'];

    public function sql()
    {
        //
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
