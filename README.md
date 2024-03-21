# **Teams**

A laravel package from [**Codelab**](https://codelab.mw) that handles team management business logic onbehalf of your laravel application. It can be used with any UI framework.

The main purpose of the package is to provide resource sharing as well as compartmentalization of the shared resources.

## Installation

To add the package in your laravel project run the following command.

`composer require codelabmw/teams`

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

The `create` or `createTeam` functions expects the following fields.

---

> **name**: *The team name*. Required.

> **slug**: *Usually the name in lowercase and hyphanated*. Optional.

> **description**: *An optional description of the team*. Optional.

> **status**: *An integer between 1 and 2 indicating whether the team is active or inactive respectively*. Defaults to 1 (Active). *You can the Status enum provided by the package*.

---

*You can find a comprehensive list of helper methods [here](#helper-methods)*

### Adding members to team

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

By default the package will assume that the `App\Models\User` class is the member entity. This behavior can be changed in the config file, specify your own member entity class on the `member` attribute.

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

*You can find a comprehensive list of helper methods [here](#helper-methods)*

### Adding resources to team

Because the package does not know how many and what kind of resources your application will have, things have to be done manually. Following are the steps to adding resource sharing.

First add the `IsResource` trait to the resource entity *(model class acting as a resource)* in your application.

``` php
<?php
...
use Codelab\Teams\Traits\IsResource;

class Task extends Model {
    IsResource;
    ...
}
```

Secondly extend the base `Codelab\Teams\Models\Team` class in a custom team class.

``` php
<?php
...
use Codelab\Teams\Models\Team;

class CustomTeam extends Team {
    ...
}
```

To let the package know of the new custom class, change the `team` attribute in the config file.

``` php
<?php

return [
    'team' => Your\Custom\Team::class
];
```

And then finally create a relationship between the resource and the team in the new custom team class using the `morphByResource` method.

``` php
<?php
...
use Codelab\Teams\Models\Team;

class CustomTeam extends Team {
    /**
     * Defines a has many tasks relationship on team.
     * 
     * @return MorphToMany
     */
    public function tasks(): MorphToMany
    {
        return $this->morphedByResource(Task::class);
    }
}
```

Once all this is done you can go ahead to add resources to team objects using the relationship method you just created.

``` php
$team->tasks()->create([...]);
```

``` php
$team->tasks()->attach($task);
```

## Glossary

### Helper methods

#### On the object that has teams

```php
createTeam([
    'name' => $name // required, 
    'slug' => $slug // optional, 
    'description' => $description // optional, 
    'status' => $status // either 1 (active) or 2 (inactive) defaults to 1,
]): Team
```

``` php
teams(): MorphMany
```

``` php
findTeam(
    $id // required.
): Team
```

``` php
deleteTeam(
    $id // required
): void
```

``` php
hasTeam(
    $id //required
): bool
```

#### On a team object

``` php
members(): MorphToMany
```

``` php
addMember(
    $id // member id, required.
): void
```

``` php
removeMember(
    $id // member id, required
): void
```

``` php
hasMember(
    $id // member id, required
): bool
```

#### On a member object

``` php
memberTeams(): MorphToMany
```

``` php
joinTeam(
    $id // team id, required.
): void
```

``` php
exitTeam(
    $id // team id, required.
): void
```

``` php
isMemberOf(
    $id // team id, required.
): bool
```

#### On a resource object

``` php
teams(): MorphToMany
```

---

Thank you for checking out the package, don't forget to **share** and :star2: if you liked it :grin:.
