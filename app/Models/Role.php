<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'role_name',
        'slug',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Role has many users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Role has many permissions
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Scope active roles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
