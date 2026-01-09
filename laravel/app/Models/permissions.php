<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    protected $fillable = [
        'name',
    ];
    // Relationship: A permission can belong to many roles
    public function roles()
    {
        return $this->belongsToMany(role::class, 'permission_roles', 'permission_id', 'role_id');
    }

}
