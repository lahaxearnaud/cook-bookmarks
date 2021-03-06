<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
 */

Artisan::add(new DatabaseResetCommand);
Artisan::add(new DataMigrateCommand);
Artisan::add(new QueueAddCommand);

// QA
Artisan::add(new QualitySynthaxCommand);
Artisan::add(new QualitySynthaxFixerCommand);
Artisan::add(new QualityTestCommand);
Artisan::add(new QualityComposerSecurityCommand);
Artisan::add(new CopyPastDetectorCommand);
Artisan::add(new DocsGenerateCommand);

// ES

Artisan::add(new ElascticSearchInstallCommand);
Artisan::add(new ElascticSearchUninstallCommand);
