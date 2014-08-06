<?php

$app = require __DIR__ . '/../../bootstrap/start.php';

$app->setRequestForConsoleEnvironment();

$app->boot();

Artisan::call('db:seed');
Artisan::call('es:uninstall');
Artisan::call('es:install');

Mail::pretend(true);
