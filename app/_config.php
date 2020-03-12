<?php

use SilverStripe\Core\Environment;
use SilverStripe\Security\PasswordValidator;
use SilverStripe\Security\Member;
use SilverStripe\ORM\DB;

// Hacky config set.
Environment::setEnv('SS_DATABASE_CLASS', 'MySQLDatabase');
Environment::setEnv('SS_DATABASE_SERVER', getenv('MARIADB_HOST', TRUE) ?: 'mariadb');
Environment::setEnv('SS_DATABASE_USERNAME', getenv('MARIADB_USERNAME') ?: 'drupal');
Environment::setEnv('SS_DATABASE_PASSWORD', getenv('MARIADB_PASSWORD') ?: 'drupal');
Environment::setEnv('SS_DATABASE_NAME', getenv('MARIADB_DATABASE') ?: 'drupal');
Environment::setEnv('SS_DEFAULT_ADMIN_USERNAME', getenv('SS_DEFAULT_ADMIN_USERNAME') ?: 'admin');
Environment::setEnv('SS_DEFAULT_ADMIN_PASSWORD', getenv('SS_DEFAULT_ADMIN_PASSWORD') ?: 'super-secret-admin-pass');
Environment::setEnv('SS_ENVIRONMENT_TYPE', getenv('SS_ENVIRONMENT_TYPE') ?: 'test');

$databaseConfig = [
    'type' => Environment::getEnv('SS_DATABASE_CLASS'),
    'server' => Environment::getEnv('SS_DATABASE_SERVER'),
    'username' => Environment::getEnv('SS_DATABASE_USERNAME'),
    'password' => Environment::getEnv('SS_DATABASE_PASSWORD'),
    'database' => Environment::getEnv('SS_DATABASE_NAME'),
];
DB::setConfig($databaseConfig);

// remove PasswordValidator for SilverStripe 5.0
$validator = PasswordValidator::create();
// Settings are registered via Injector configuration - see passwords.yml in framework
Member::set_password_validator($validator);
