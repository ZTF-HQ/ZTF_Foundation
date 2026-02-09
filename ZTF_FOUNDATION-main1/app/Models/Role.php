<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'grade',
        'description',
        'code'
    ];

    /**
     * Relation Many-to-Many avec User
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }

    /**
     * Relation Many-to-Many avec Permission
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_roles', 'role_id', 'permission_id');
    }

    /**
     * Trouver un rôle par son nom
     *
     * @param string $name
     * @return Role|null
     */
    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }

    /**
     * Trouver un rôle par son code
     *
     * @param string $code
     * @return Role|null
     */
    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }
}
