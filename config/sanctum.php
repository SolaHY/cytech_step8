<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | Here you may configure the domains that should be treated as "stateful".
    | This will ensure that these domains are able to make requests to your
    | application without being prompted for their CSRF token. Of course,
    | you are free to add additional domains to this list if needed.
    |
    */

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ','.parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | Here you may configure the authentication guards that should be used
    | when making requests. You may specify any of the guards configured
    | in your "auth" configuration file.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This value controls the number of minutes until an issued token will be
    | considered expired. This will override any values set in blacklisted
    | tokens and reset the token's lifetime. Of course, you may change this
    | value as needed.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | Sanctum can prefix new tokens in order to take advantage of various
    | security scanning and detection tools. If you would like to prefix
    | your tokens, you may specify a prefix below.
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | When utilizing the Sanctum authentication system, you may configure
    | the middleware that should be assigned to the routes that expose
    | your application's API endpoints. These middleware will be assigned
    | to the group named "api" in your application's route configuration.
    |
    */

    'middleware' => [
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
    ],
]; 