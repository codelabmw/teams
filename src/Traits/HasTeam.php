<?php

namespace Codelab\Teams\Traits;

use Codelab\Teams\Exceptions\TeamNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Codelab\Teams\Models\Team;

trait HasTeam
{
    
    /**
     * Defines a has many relationship between an entity (parent) and a team.
     * 
     * @return MorphMany
     */
    public function teams(): MorphMany
    {
        $team = config('teams.team');
        return $this->morphMany($team, 'teamable');
    }

    /**
     * Helper function to create a team on this entity.
     * 
     * @param array $fields
     * @return Team
     */
    public function createTeam($fields): Team
    {
        $team = $this->teams()->create($fields);

        return $team;
    }

    /**
     * Helper function to get a single team using an id.
     * 
     * @param int|string $id
     * @return Team
     * @throws TeamNotFoundException
     */
    public function findTeam($id): Team
    {
        $team = $this->teams()->find($id);

        if (!$team) {
            throw new TeamNotFoundException;
        }

        return $team;
    }

    /**
     * Helper function to delete a team using an id. 
     * 
     * @param int|string $id
     * @throws TeamNotFoundException
     */
    public function deleteTeam($id)
    {
        $team = $this->findTeam($id);

        $team->delete();
    }

    /**
     * Helper function to check if team exists.
     * 
     * @param int|string $id
     * @return bool
     */
    public function hasTeam($id): bool
    {
        try {
            $this->findTeam($id);

            return true;
        } catch (TeamNotFoundException $e) {
            return false;
        }
    }
}