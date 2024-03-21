<?php

namespace Codelab\Teams\Traits;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait IsResource {
    
    /**
     * Defines a has many relationship between a resource and a team.
     * 
     * @return MorphToMany
     */
    public function teams() : MorphToMany
    {
        $team = config('teams.team');
        return $this->morphToMany($team, 'resourceable', 'resource_team');
    }
}