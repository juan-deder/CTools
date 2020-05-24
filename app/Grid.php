<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function contents()
    {
        return  $this->hasMany(\App\Content::class);
    }

    public function commiters()
    {
        return $this->belongsToMany(User::class, 'grid_commitment')->as('commitment')->withPivot('roles');
    }
}
