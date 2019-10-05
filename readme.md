# Laravel Rollout

A Laravel package for [opensoft/rollout](https://github.com/opensoft/rollout)

[![Build Status](https://travis-ci.org/Jaspaul/laravel-rollout.svg?branch=master)](https://travis-ci.org/Jaspaul/laravel-rollout) [![Coverage Status](https://coveralls.io/repos/github/Jaspaul/laravel-rollout/badge.svg?branch=master)](https://coveralls.io/github/Jaspaul/laravel-rollout?branch=master) [![Code Climate](https://codeclimate.com/github/Jaspaul/laravel-rollout/badges/gpa.svg)](https://codeclimate.com/github/Jaspaul/laravel-rollout)

## Installation

### Composer

```sh
composer require jaspaul/laravel-rollout
```

### Configuring the Service Provider

Package discovery will configure the service provider automatically.

### Setting up Storage

#### Publish the Configuration

```sh
php artisan vendor:publish --provider 'Jaspaul\LaravelRollout\ServiceProvider'
```

#### Setting up a Cache

If you intend to use cache to store the settings for rollout, be sure to [enable the cache](https://laravel.com/docs/6.x/cache) for your Laravel application. Note if you are using the cache, a cache clear during deployment will cause your rollout settings to be purged. If you require persistence for these settings use the option below.

#### Setting up Persistent Storage

This will allow you to have rollout settings be persisted even if you clear the application cache for every deployment.

##### Running the Migrations

```sh
php artisan migrate
```

##### Configuring your Environment

```
ROLLOUT_STORAGE=database
ROLLOUT_TABLE=rollout
```

### Implementing Interfaces

##### User
Your rollout users must implement the `\Jaspaul\LaravelRollout\Contracts\User` interface. Often this will be your main user object:

```php
<?php

use Jaspaul\LaravelRollout\Helpers\User as Contract;

class User implements Contract
{
    /**
     * @return string
     */
    public function getRolloutIdentifier()
    {
        return $this->id;
    }
}
```

#### Group
Your rollout groups must implement the `\Jaspaul\LaravelRollout\Contracts\Group` interface.

```php
<?php

use Jaspaul\LaravelRollout\Contracts\Group;

class BetaUsersGroup implements Group
{
    /**
     * The name of the group.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'beta-users';
    }

     /**
     * Defines the rule membership in the group.
     *
     * @return boolean
     */
    public function hasMember($user = null): bool
    {
        if (!is_null($user)) {
            return $user->hasOptedIntoBeta();
        }

        return false;
    }
}
```

and you should update your local `laravel-rollout.php` configuration to include the group in the groups array:

`laravel-rollout.php`
```php
return [
    ...
    'groups' => [
        BetaUsersGroup::class
    ],
    ...
]
```

## Commands

### Add Group

`php artisan rollout:add-group {feature} {group}`

Swap `{feature}` with the name of the feature, and `{group}` with the name you defined in the group class.

### Add User

`php artisan rollout:add-user {feature} {user}`

Swap `{feature}` with the name of the feature, and `{user}` with a unique identifier for the user in your system.

### Create

`php artisan rollout:create {feature}`

Swap `{feature}` with the name of the feature you'd like to create a feature flag for.

### Deactivate

`php artisan rollout:deactivate {feature}`

Swap `{feature}` with the name of the feature you'd like to deactivate globally. Note this will also reset the user whitelist.

### Delete

`php artisan rollout:delete {feature}`

Swap `{feature}` with the name of the feature you'd like to permanently delete from rollout.

### Everyone

`php artisan rollout:everyone {feature}`

Swap `{feature}` with the name of the feature you'd like to rollout to 100% of your user base.

### List

`php artisan rollout:list`

![](https://cloud.githubusercontent.com/assets/2836589/24476459/4773446c-14a1-11e7-8ea5-132fe747e0ac.png)

### Percentage

`php artisan rollout:percentage {feature} {percentage}`

Swap `{feature}` with the name of the feature you'd like to rollout, and `{percentage}` with the percentage of users to rollout the feature to.

### Remove Group

`php artisan rollout:remove-group {feature} {group}`

Swap `{feature}` with the name of the feature, and `{group}` with the name you defined in the group class.

### Remove User

`php artisan rollout:remove-user {feature} {user}`

Swap `{feature}` with the name of the feature, and `{user}` with a unique identifier for the user in your system to remove the feature from.
