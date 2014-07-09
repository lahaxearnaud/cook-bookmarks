<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Crada\Apidoc\Builder;
use Crada\Apidoc\Exception;

class DocsGenerateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'doc:gen';

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
        $classes = array(
            'ArticlesController',
        );

        $output_dir  = 'public/docs';
        $output_file = 'api.html'; // defaults to index.html

        try {
            $builder = new Builder($classes, $output_dir, $output_file);
            $builder->generate();
        } catch (Exception $e) {
            echo 'There was an error generating the documentation: ', $e->getMessage();
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
		);
	}

}
