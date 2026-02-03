<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * Relation Many-to-Many avec Role
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    /**
     * Trouver une permission par son nom
     *
     * @param string $name
     * @return Permission|null
     */
    public static function findByName(string $name): ?self
    {
        return static::where('name', $name)->first();
    }
}
