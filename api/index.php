<?php

// Trust HTTPS headers from Vercel
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// Force ASSET_URL to root-relative so assets never point to localhost
putenv('ASSET_URL=/');
$_ENV['ASSET_URL'] = '/';
$_SERVER['ASSET_URL'] = '/';

// Dynamic APP_URL from host header
if (isset($_SERVER['HTTP_HOST'])) {
    $proto = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
    $currentAppUrl = $proto . '://' . $_SERVER['HTTP_HOST'];
    putenv("APP_URL={$currentAppUrl}");
    $_ENV['APP_URL'] = $currentAppUrl;
    $_SERVER['APP_URL'] = $currentAppUrl;
}

// Check if request is for a static asset in /public (safety fallback)
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
$cleanUri = preg_replace('#^/public/#', '/', $uri);
$publicFile = __DIR__ . '/../public' . $cleanUri;

if ($cleanUri !== '/' && file_exists($publicFile) && is_file($publicFile)) {
    $ext = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css; charset=utf-8',
        'js'    => 'application/javascript; charset=utf-8',
        'json'  => 'application/json',
        'svg'   => 'image/svg+xml',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
    ];

    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
        header('Cache-Control: public, max-age=31536000, immutable');
        readfile($publicFile);
        exit;
    }
}

// Prepare writable paths in Vercel serverless /tmp
$dirs = [
    '/tmp/views',
    '/tmp/storage',
    '/tmp/storage/app',
    '/tmp/storage/app/public',
    '/tmp/storage/framework',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Copy pre-seeded SQLite database to writable /tmp if using sqlite
$srcSqlite = __DIR__ . '/../database/database.sqlite';
$destSqlite = '/tmp/database.sqlite';

if (file_exists($srcSqlite) && (!file_exists($destSqlite) || filesize($destSqlite) !== filesize($srcSqlite))) {
    copy($srcSqlite, $destSqlite);
}

// Forward Vercel serverless requests to the Laravel front controller
require __DIR__ . '/../public/index.php';
