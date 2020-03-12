<?php

use SilverStripe\Control\HTTPApplication;
use SilverStripe\Control\HTTPRequestBuilder;
use SilverStripe\Core\CoreKernel;

// Find autoload.php
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo "autoload.php not found";
    exit(1);
}


// Hacky config set.
$env = [
    'SS_DATABASE_CLASS' => getenv('SS_DATABASE_CLASS', TRUE) ?: 'MySQLDatabase',
    'SS_DATABASE_SERVER' => getenv('MARIADB_HOST', TRUE) ?: 'mariadb',
    'SS_DATABASE_USERNAME' => getenv('MARIADB_USERNAME') ?: 'drupal',
    'SS_DATABASE_PASSWORD' => getenv('MARIADB_PASSWORD') ?: 'drupal',
    'SS_DATABASE_NAME' => getenv('MARIADB_DATABASE') ?: 'drupal',
    'SS_DEFAULT_ADMIN_USERNAME' => getenv('SS_DEFAULT_ADMIN_USERNAME') ?: 'admin',
    'SS_DEFAULT_ADMIN_PASSWORD' => getenv('SS_DEFAULT_ADMIN_PASSWORD') ?: 'super-secret-admin-pass',
    'SS_ENVIRONMENT_TYPE' => getenv('SS_ENVIRONMENT_TYPE') ?: 'test',
];

foreach ($env as $name => $value) {
    putenv("$name=$value");
}

// Build request and detect flush
$request = HTTPRequestBuilder::createFromEnvironment();

// Default application
$kernel = new CoreKernel(BASE_PATH);
$app = new HTTPApplication($kernel);
$response = $app->handle($request);
$response->output();
