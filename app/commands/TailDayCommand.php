<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class tailDay
 *
 *
 *
 * @author LAHAXE Arnaud <alahaxe@boursorama.fr>
 */
class TailDayCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tail:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tail current log file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        // get the logFile name with day rotation
        $logFile = 'log-' . $this->option('type') . '-' . date('Y-m-d') . '.log';
        $path = storage_path() . '/logs/' . $logFile;

        // call the tail command with the local path
        $this->call('tail', array(
            '--path' => $path,
            '--lines' => $this->option('lines')
        ));

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

        return array(
            array('type', null, InputOption::VALUE_OPTIONAL, 'Type log (ex cli, apache2...)', 'apache2'),
            array('lines', null, InputOption::VALUE_OPTIONAL, 'The number of lines to tail.', 20),
        );
    }

}
