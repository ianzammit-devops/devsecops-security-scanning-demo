<?php

/**
 * Application configuration.
 *
 * Database settings are taken from environment variables so that no secrets
 * are committed to source control.
 *
 * You can provide them either via your web server/PHP-FPM environment or
 * via a local `.env` file in this directory (not committed to git).
 */

// Very small .env loader for local development.
// If a `.env` file exists, parse KEY=VALUE lines into $_ENV/$_SERVER.
$envFile = __DIR__ . '/.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }
        [$key, $value] = array_pad(explode('=', $line, 2), 2, null);
        $key = trim($key);
        $value = $value === null ? '' : trim($value);
        if ($key !== '') {
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

return [
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? null,
        'port' => isset($_ENV['DB_PORT']) ? (int) $_ENV['DB_PORT'] : null,
        'name' => $_ENV['DB_NAME'] ?? null,
        'user' => $_ENV['DB_USER'] ?? null,
        'password' => $_ENV['DB_PASSWORD'] ?? null,
    ],
];

