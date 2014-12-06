<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
        $verbose = ($this->getOutput()->getVerbosity() > 1) ? '-vvv' : '';
        $suite   = $this->argument('suite');
        $test    = $this->argument('test');

        $process = new Process('php artisan serve --host=cuisine.dev --port=8100');
        $process->start(function ($type, $buffer) {
            $this->info($buffer);
        });
        $process->setTimeout(60 * 60 * 60);// 1H
        sleep(3);

        $report = '';
        if ($this->option('coverage') !== 'none') {
            $report = '--coverage --report --' . $this->option('coverage');
        }

        $codeception = 'vendor/bin/codecept run ' . $suite . ' ' . $test . ' ' . $verbose . ' ' . $report . ' --no-interaction';
        $processTest = new Process($codeception);
        $processTest->setTimeout(60 * 60 * 60);// 1H
        $processTest->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                if (strlen($buffer) === 1) {
                    echo $buffer;
                } else {
                    $this->output->writeln($buffer);
                }
            }
        });

        $process->stop(0);

        if (!$processTest->isSuccessful()) {
            throw new Exception('Tests failed.', $processTest->getExitCode());
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('suite', null, InputArgument::OPTIONAL, ''),
            array('test', null, InputArgument::OPTIONAL, ''),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('coverage', 'coverage', InputOption::VALUE_OPTIONAL, 'Code coverage none|tap|html|xml', 'none')
        );
    }
}
