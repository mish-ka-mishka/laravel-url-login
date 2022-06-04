<?php

/**
 * @see https://github.com/mish-ka-mishka/laravel-url-login
 */

return [
    /*-------------------------------------------------------------------------
    | Auth token length
    |--------------------------------------------------------------------------
    |
    | Here you can specify auth token length in bytes
    |
    */
    'auth_token_length' => 60,

    /*-------------------------------------------------------------------------
    | Auth token expire
    |--------------------------------------------------------------------------
    |
    | Here you can specify whether auth token should have an expiration date
    |
    */
    'auth_token_expire' => true,

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
