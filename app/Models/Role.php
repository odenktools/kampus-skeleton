<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Role Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools Technology
 */
class Role extends Model
{
    use SoftDeletes;

    public $table = 'roles';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['name', 'description', 'is_active'];

    /**
     * Casting data type.
     *
     * @var array
     */
    protected $casts = ['is_active' => 'boolean'];

    public function sql()
    {
        return $this
            ->select(
                $this->table.'.id',
                $this->table.'.name',
                $this->table.'.description',
                $this->table.'.is_active'
            )->orderBy(
                $this->table.'.name'
            );
    }

    public function user_role()
    {
        return $this->hasMany(\App\Models\UserRole::class);
    }
}
