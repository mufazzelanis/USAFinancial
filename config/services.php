<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Meta (Facebook) Conversions API — server-side event tracking, deduplicated
    // with the browser Pixel via a shared event_id. The Pixel ID itself is public
    // (it's visible in every page's source) and lives in admin Site Settings, but
    // the access token is a real secret with write access to your ad account's
    // event data — it belongs in .env only, never in the database or an admin
    // form. Generate it in Meta Events Manager > Data Sources > your Pixel >
    // Settings > Conversions API > Generate Access Token.
    'meta_capi' => [
        'access_token' => env('FACEBOOK_CAPI_ACCESS_TOKEN'),
        // Optional: paste a Test Event Code from Events Manager > Test Events
        // while verifying setup; remove it again once you've confirmed events arrive.
        'test_event_code' => env('FACEBOOK_CAPI_TEST_EVENT_CODE'),
    ],

];
