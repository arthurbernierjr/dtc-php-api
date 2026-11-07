#!/bin/sh
set -e
cd /app
cp .env.example .env
php <<'PHP'
<?php
$lines = file('.env');
$want = [
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'DB_CONNECTION' => 'pgsql',
    'DB_HOST' => getenv('PGHOST') ?: '',
    'DB_PORT' => getenv('PGPORT') ?: '5432',
    'DB_DATABASE' => getenv('PGDATABASE') ?: '',
    'DB_USERNAME' => getenv('PGUSER') ?: '',
    'DB_PASSWORD' => getenv('PGPASSWORD') ?: '',
];
$seen = [];
$out = [];
foreach ($lines as $line) {
    $trim = ltrim($line);
    $key = strtok($trim, '=');
    if (isset($want[$key])) {
        $out[] = $key.'="'.str_replace('"', '\\"', $want[$key])."\"\n";
        $seen[$key] = true;
        continue;
    }
    $out[] = $line;
}
foreach ($want as $key => $value) {
    if (!isset($seen[$key])) {
        $out[] = $key.'="'.str_replace('"', '\\"', $value)."\"\n";
    }
}
file_put_contents('.env', implode('', $out));
PHP
php artisan key:generate --force
php artisan migrate --force
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
