<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $fillable = [
        'name',
    ];

    // Relationship: A role can have many permissions
    public function permissions()
    {
        return $this->belongsToMany(permissions::class, 'permission_roles', 'role_id', 'permission_id');
    }

    // Relationship: A role can belong to many users
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }
}
