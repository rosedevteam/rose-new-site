<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'admin' => [
        'prefix' => env('ADMIN_PREFIX', 'kara-fa'),
    ],

    'sms' => [
        'api' => env('SMS_API'),
        'referral_after_register_template' => env('SMS_REFERRAL_AFTER_REGISTER'),
    ],

    'spotplayer' => [
        'api' => env('SPOT_PLAYER_API'),
    ],

    'cart' => [
        'cookie-name' => env('CART_COOKIE_NAME')
    ],

    'sourcearena' => [
        'token' => env('SOURCE_ARENA_TOKEN'),
    ],

    'referral_scores' => [
        'score_after_register' => env('SCORE_AFTER_REGISTER'),
        'score_after_complete_order' => env('SCORE_AFTER_ORDER')
    ]
];
