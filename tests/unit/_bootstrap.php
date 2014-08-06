<?php

$app = require __DIR__ . '/../../bootstrap/start.php';

$app->setRequestForConsoleEnvironment();

$app->boot();

Mail::pretend(true);
Artisan::call('db:seed');
Artisan::call('es:uninstall');
Artisan::call('es:install');
