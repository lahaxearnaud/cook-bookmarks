<?php

use Illuminate\Console\Command;

class DatabaseResetCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'db:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete and re-install all data and databas migration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->call('migrate:reset');
        $this->call('migrate');
        $this->call('db:seed');
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
