<?php

$app = require __DIR__ . '/../../bootstrap/start.php';

$app->setRequestForConsoleEnvironment();

$app->boot();

Artisan::call('migrate:reset');
Artisan::call('migrate');
Artisan::call('db:seed');
Mail::pretend(true);
Log::info('Boot');