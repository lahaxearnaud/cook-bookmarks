<?php

use Illuminate\Console\Command;
use SensioLabs\Security\SecurityChecker;

class QualityComposerSecurityCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'qa:composer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test composer.lock with security.sensiolabs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $checker = new SecurityChecker();
        $alerts = $checker->check('composer.lock');
        if($checker->getLastVulnerabilityCount() === 0) {
            $this->info($alerts);
        }else{
            $this->error($alerts);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }
}
