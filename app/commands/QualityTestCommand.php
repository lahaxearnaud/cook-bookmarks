<?php

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class QualityTestCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'qa:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start test server and run tests';

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
        $process = new Process('php artisan serve --host=cuisine.dev --port=8100');
        $process->start(function ($type, $buffer) {
            $this->info($buffer);
        });
        $process->setTimeout(60*60*60);// 1H
        sleep(5);
        $processTest = new Process('vendor/bin/codecept run ');
        $processTest->setTimeout(60*60*60);// 1H
        $processTest->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                if(strlen($buffer) === 1) {
                    echo $buffer;
                }else{
                    $this->output->writeln($buffer);
                }
            }
        });

        $process->stop(0);
        exit($processTest->getStatus());
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
