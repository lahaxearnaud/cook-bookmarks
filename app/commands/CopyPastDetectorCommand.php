<?php

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class CopyPastDetectorCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'qa:phpcpd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $process = new Process('vendor/bin/phpcpd app workbench --exclude=tests');
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                if(strlen($buffer) === 1) {
                    echo $buffer;
                }else{
                    $this->info($buffer);
                }
            }
        });
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

    protected function exec($command)
    {
        $return = null;
        exec($command, $return);
        foreach ($return as $ligne) {
            $this->info($ligne);
        }
    }

}
