<?php

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

if (!file_exists($destSqlite) && file_exists($srcSqlite)) {
    copy($srcSqlite, $destSqlite);
}

// Forward Vercel serverless requests to the Laravel front controller
require __DIR__ . '/../public/index.php';
