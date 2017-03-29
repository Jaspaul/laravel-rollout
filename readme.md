# Laravel Rollout

A Laravel package for [opensoft/rollout](https://github.com/opensoft/rollout)

[![Build Status](https://travis-ci.org/Jaspaul/laravel-rollout.svg?branch=master)](https://travis-ci.org/Jaspaul/laravel-rollout) [![Coverage Status](https://coveralls.io/repos/github/Jaspaul/laravel-rollout/badge.svg?branch=master)](https://coveralls.io/github/Jaspaul/laravel-rollout?branch=master) [![Code Climate](https://codeclimate.com/github/Jaspaul/laravel-rollout/badges/gpa.svg)](https://codeclimate.com/github/Jaspaul/laravel-rollout)

## Installation

### Composer

```sh
composer require jaspaul/laravel-rollout
```

### Setting up a Cache

Be sure to [enable the cache](https://laravel.com/docs/5.4/cache) for your Laravel application. This package uses the cache to store the rollout settings.

### Configuring the Service Provider

Open config/app.php and register the required service provider above your application providers.

```php
'providers' => [
    ...
    Jaspaul\LaravelRollout\ServiceProvider::class
    ...
]
```

### Implementing Interfaces

Your rollout users must implement the `\Jaspaul\LaravelRollout\Helpers\User` interface. Often this will be your main user object:

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

## Commands

### List

`php artisan rollout:list`

![](https://cloud.githubusercontent.com/assets/2836589/24476459/4773446c-14a1-11e7-8ea5-132fe747e0ac.png)

### Create

`php artisan rollout:create {feature}`

Swap `{feature}` with the name of the feature you'd like to create a feature flag for.

### Add User

`php artisan rollout:add-user {feature} {user}`

Swap `{feature}` with the name of the feature, and `{user}` with a unique identifier for the user in your system.
