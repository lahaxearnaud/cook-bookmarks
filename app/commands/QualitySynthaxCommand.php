<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class QualitySynthaxCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'qa:synthax';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PHP cs';

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
        $file    = $this->argument('file');
        $process = new Process('vendor/bin/phpcs --extensions=php --ignore=*/tests/*,*/storage/*,*.blade.php --standard=PSR2  -p ' . $file);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                $text = trim($buffer);
                if (strlen($text) == 1) {
                    if ($text != '.') {
                        $this->output->write("<error>" . $text . "</error>");
                    } else {
                        $this->output->write("<info>" . $text . "</info>");
                    }
                } else {
                    $this->output->writeln($buffer);
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

        return array(
            array('file', null, InputArgument::OPTIONAL, 'app workbench', 'File(s)/Folder(s) to test',)
        );
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
