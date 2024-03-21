<?php
use App\Models\User;
use Codelab\Teams\Models\Team;

return [
    /**
     * The class that acts as the member of a team.
     */
    'member' => User::class,

    /**
     * If you need to add functionality to the team class, create your
     * own class and extend the team class, and then add your custom class here.
     */
    'team' => Team::class,
];