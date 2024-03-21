<?php

namespace Codelab\Teams\Models;

use Codelab\Teams\Exceptions\MemberNotFoundException;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'slug',
        'name',
        'description',
        'status',
    ];

    /**
     * Team can belong to an entity of any form.
     * 
     * @return MorphTo
     */
    public function teamable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Members as users belonging to this team. 
     * This behavior is by default, it assumes that the team mebers will be of type User. The default behaviour can be changed in the config file.
     * 
     * @return MorphToMany
     */
    public function members(): MorphToMany
    {
        return $this->morphedByMany(config('teams.member'), 'memberable', 'member_team');
    }

    /**
     * Helper function to add a team member to the team using members id.
     * 
     * @param int|string $id
     */
    public function addMember($id)
    {
        $member = $this->findMemberOrFail($id);

        $this->members()->attach($member);
    }

    /**
     * Helper function to remove a team member using members id.
     * 
     * @param int|string $id
     * @throws MemberNotFoundException
     */
    public function removeMember($id)
    {
        $member = $this->findMemberOrFail($id);

        DB::table('member_team')->whereColumn('memberable_id', '=', $member->id)->delete();
    }

    /**
     * Helper function to check if team has specified member.
     * 
     * @param int|string $id
     * @return bool
     */
    public function hasMember($id): bool
    {
        $results = $this->members()->where('memberable_id', '=', $id)->get()->count();

        return $results > 0;
    }

    /**
     * Helper function to find a member or fail.
     * 
     * @param int|string $id
     * @return mixed
     */
    private function findMemberOrFail($id): mixed
    {
        $member_class = config('teams.member');
        $member = $member_class::find($id);

        if (!$member) {
            throw new MemberNotFoundException;
        }

        return $member;
    }
}
