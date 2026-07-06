<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'breadcrumbs' => [
        // Registrar consultas de base de datos como breadcrumbs
        'sql_queries' => true,
        // Registrar cache events
        'cache' => true,
        // Registrar HTTP requests
        'http_client_requests' => true,
    ],
    'traces_sample_rate' => (float) env('SENTRY_TRACES_SAMPLE_RATE', 0.1),
    'profiles_sample_rate' => (float) env('SENTRY_PROFILES_SAMPLE_RATE', 0.0),
    'environment' => env('SENTRY_ENVIRONMENT', env('APP_ENV', 'production')),
    'release' => env('APP_VERSION', '1.0.0'),
    'max_request_body_size' => 'medium',
    'attach_stacktrace' => true,
];
