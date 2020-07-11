<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'profile_image', 'federated_by', 'federated_id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function grids()
    {
        return $this->belongsToMany(Grid::class, 'grid_commitments')->as('commitment')->withPivot(['roles'])->withTimestamps();
    }
}
