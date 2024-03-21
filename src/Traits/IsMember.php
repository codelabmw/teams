<?php

namespace Codelab\Teams\Traits;

use Codelab\Teams\Exceptions\TeamNotFoundException;
use Codelab\Teams\Exceptions\MemberNotFoundException;
use Codelab\Teams\Models\Team;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait IsMember
{
    
    /**
     * Defines a has many relationship between a member and teams membered.
     * 
     * @return MorphToMany
     */
    public function memberTeams(): MorphToMany
    {
        $team = config('teams.team');
        return $this->morphToMany($team, 'memberable', 'member_team');
    }

    /**
     * Helper function to join a team as a member using a team id.
     * 
     * @param int|string $id
     * @throws TeamNotFoundException
     * @throws MemberNotFoundException
     */
    public function joinTeam($id)
    {
        $team = $this->findTeamOrFail($id);

        $team->addMember($this->id);
    }

    /**
     * Helper function to exit a team using a team id.
     * 
     * @param int|string $id
     * @throws TeamNotFoundException
     * @throws MemberNotFoundException
     */
    public function exitTeam($id)
    {
        $team = $this->findTeamOrFail($id);

        $team->removeMember($this->id);
    }

    /**
     * Helper funtion to check if member is of specified team.
     * 
     * @param int|string $id
     * @return bool
     */
    public function isMemberOf($id): bool
    {
        $team = $this->findTeamOrFail($id);

        return $team->hasMember($this->id);
    }

    /**
     * Helper function to find a team or fail.
     * 
     * @param int|string $id
     * @return Team
     * @throws TeamNotFoundException
     */
    private function findTeamOrFail($id): Team
    {
        $team_class = config('teams.team');
        $team = $team_class::find($id);

        if (!$team) {
            throw new TeamNotFoundException;
        }

        return $team;
    }
}