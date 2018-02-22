# Laravel Rollout

A Laravel package for [opensoft/rollout](https://github.com/opensoft/rollout)

[![Build Status](https://travis-ci.org/Jaspaul/laravel-rollout.svg?branch=master)](https://travis-ci.org/Jaspaul/laravel-rollout) [![Coverage Status](https://coveralls.io/repos/github/Jaspaul/laravel-rollout/badge.svg?branch=master)](https://coveralls.io/github/Jaspaul/laravel-rollout?branch=master) [![Code Climate](https://codeclimate.com/github/Jaspaul/laravel-rollout/badges/gpa.svg)](https://codeclimate.com/github/Jaspaul/laravel-rollout)

## Installation

### Composer

```sh
composer require jaspaul/laravel-rollout
```

### Configuring the Service Provider

On Laravel 5.5, the package discovery will configure the service provider automatically.

On Laravel 5.4, open config/app.php and register the required service provider above your application providers.

```php
'providers' => [
    ...
    Jaspaul\LaravelRollout\ServiceProvider::class
    ...
]
```

### Setting up Storage

#### Publish the Configuration

```sh
php artisan vendor:publish --provider 'Jaspaul\LaravelRollout\ServiceProvider'
```

#### Setting up a Cache

If you intend to use cache to store the settings for rollout, be sure to [enable the cache](https://laravel.com/docs/5.4/cache) for your Laravel application. Note if you are using the cache, a cache clear during deployment will cause your rollout settings to be purged. If you require persistence for these settings use the option below.

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

### Remove User

`php artisan rollout:remove-user {feature} {user}`

Swap `{feature}` with the name of the feature, and `{user}` with a unique identifier for the user in your system to remove the feature from.

## Usage
In addition to interacting to the rollout class, Laravel Rollout also provides some additional helpers.

### Helpers
```php
    $rollout = rollout(); // Returns the rollout instance
    $canFeature = feature_active('share-with-friend'); // Check if a feature is active for everyone
    $canFeature = feature_active('share-with-friend', $user); // Check if a feature is active for a user
```

### User Methods
```php
    $user->featureEnabled('share-with-friend')
    $user->featureNotEnabled('share-with-friend')
```

### Middleware
Protect routes from being accessed by disabled users. You can specify multiple features using a comma (Note: *all* features must be enabled to give access).
```php
Route::get('{post}/share', [
    'as' => 'posts.share',
    'uses' => 'PostShareController@share',
    'middleware' => 'feature:share-with-friend'
]);
```