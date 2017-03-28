<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Rollout Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default location where we'll store the data
    | used by rollout.
    |
    | Supported: "database", "null"
    |
    */
    'driver' => env('ROLLOUT_DRIVER', 'database')

];
