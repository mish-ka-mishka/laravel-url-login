<?php

/**
 * @see https://github.com/mish-ka-mishka/laravel-url-login
 */

return [
    /*-------------------------------------------------------------------------
    | Model parameters names
    |--------------------------------------------------------------------------
    |
    | Here you can specify the names of the parameters that are used
    | for retrieving user from database and verifying it’s token
    |
    */
    'model_parameters' => [
        'auth_id' => 'auth_id',
        'auth_token_hash' => 'auth_token_hash',
        'auth_token_expire' => 'auth_token_expire',
    ],

    /*-------------------------------------------------------------------------
    | Auth token length
    |--------------------------------------------------------------------------
    |
    | Here you can specify auth token length in bytes
    |
    */
    'auth_token_length' => 60,

    /*-------------------------------------------------------------------------
    | Auth token lifetime
    |--------------------------------------------------------------------------
    |
    | Here you can specify how much time in minutes after generating
    | the auth token is valid.
    |
    */
    'auth_token_lifetime' => 15,
];
