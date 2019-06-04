<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Role Model.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Models
 * @copyright  (c) 2019, Odenktools
 * @link       https://odenktools.com
 */
class Role extends Model
{
    public $table = 'roles';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'is_active'];

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
