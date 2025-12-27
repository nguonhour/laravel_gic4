<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permission_role extends Model
{
    protected $fillable = [
        'permission_id',
        'role_id',
    ];
}
