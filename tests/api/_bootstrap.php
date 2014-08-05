<?php

$app = require __DIR__ . '/../../bootstrap/start.php';

$app->setRequestForConsoleEnvironment();

$app->boot();

if(!defined('setup')) {
    Artisan::call('migrate:reset');
    Artisan::call('migrate');
    Artisan::call('db:seed');
    Artisan::call('es:uninstall');
    Artisan::call('es:install');
Log::info('##############');
    define('setup', TRUE);
}

Mail::pretend(true);
