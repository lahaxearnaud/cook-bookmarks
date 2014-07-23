<?php

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class QualitySynthaxFixerCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'qa:synthax-fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PHP cs fixer';

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
        $this->fix('app');
        $this->fix('tests');
    }

    protected function fix($folder)
    {
        $process = new Process('vendor/bin/php-cs-fixer fix '.$folder.' --fixers=indentation,php_closing_tag,return,function_declaration,lowercase_keywords,object_operator,elseif,lowercase_keywords,trailing_spaces,unused_use,extra_empty_lines,braces,return,phpdoc_params,eof_ending,visibility -v');
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
}
