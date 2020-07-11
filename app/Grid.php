<?php

namespace App;

class Grid extends Model
{
    protected $guarded = [];
    protected $hidden = ['updated_at'];
    protected $casts = ['active' => 'boolean'];

    public function committers()
    {
        return $this->belongsToMany(User::class, 'grid_commitments')->as('commitment')->withPivot('roles')->withTimestamps();
    }

    public function addCommitters($committers)
    {
        $this->committers()->attach($committers);
    }

    public function removeCommitters($committers)
    {
        $committers = (array) $committers;
        $this->committers()->detach($committers);
    }

    public function updateCommitterRoles(int $id, String $roles)
    {
        $this->committers()->updateExistingPivot($id, ['roles' => $roles]);
    }
}
