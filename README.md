# **Teams**

A laravel package from [**Codelab**](https://codelab.mw) that handles team management business logic onbehalf of your laravel application. It can be used with any UI framework.

The main purpose of the package is to provide resource sharing as well as compartmentalization of the shared resources.

## Installation

To add the package in your laravel project run the following command.

`composer require codelab/teams`

After the installation, run the following command to publish the migration and config files.

`php artisan vendor:publish --tag=codelab-teams`

And then run the following command to create necessary tables.

`php artisan migrate`

## Usage

### Creating a team

To start creating teams, in your model acting as a team entity *(the model of your choice to have teams)* add the `HasTeam` trait.

``` php
<?php
...

use Codelab\Teams\Traits\HasTeam;

class User extends Authenticatable
{
    HasTeam;

    ...
}
```

Once you have your entity configured you can then create teams using the teams relationship method or the provided helper method.

1. Using the team's entity `teams` relationship method.

    ``` php
    $team = $user->teams()->create([...])
    ```

2. Using the team's entity `createTeam` helper method.

    ``` php
    $team = $user->createTeam([...])
    ```

The **create** or **createTeam** functions expects the following fields.

---

- > **name**: *The team name*. Required.
- > **slug**: *Usually the name in lowercase and hyphanated*. Optional.
- > **description**: *An optional description of the team*. Optional.
- > **status**: *An integer between 1 and 2 indicating whether the team is active or inactive respectively*. Defaults to 1 (Active). *You can the Status enum provided by the package*.

---

*You can find a comprehensive list of helper functions [here]()*

### Adding members

To add a member to a team first you have to add the `IsMember` trait to your model acting as a member entity.

``` php
<?php
...

use Codelab\Teams\Traits\IsMember;

class User extends Authenticatable {
    IsMember;

    ...
}
```

By default the package will assume that the `App\Models\User` class is the member entity. This behavior can be changed in the config file, specify your own member entity class on the member attribute.

``` php
<?php

return [
    'member' => Your\Custom\Entity::class
];
```

Once you have your member entity configured, you can proceed to add members to a team by using either of the following options.

1. Using the team's object `members` relationship method.

    ``` php
    // $member = new Your\Member\Entity
    $team->members()->attach($member);
    ```

2. Using the team's object `addMember` helper method.

    ``` php
    $team->addMember($member->id)
    ```

    *The `addMember` method requires the members id as an int or string*.

3. Using the member's object `joinTeam` helper method.

    ``` php
    $member->joinTeam($team->id);
    ```

    *The `joinTeam` method requires the teams id as an int or string*.

*You can find a comprehensive list of helper functions [here]()*
