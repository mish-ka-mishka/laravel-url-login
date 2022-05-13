<?php

return [
    'model_parameters' => [
        'auth_id' => 'auth_id',
        'auth_token_hash' => 'auth_token_hash',
        'auth_token_expire' => 'auth_token_expire',
    ],
    'auth_token_length' => 60,
    'auth_token_lifetime' => 15, // minutes after generating
];
