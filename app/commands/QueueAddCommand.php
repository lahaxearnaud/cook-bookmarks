<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class QueueAddCommand extends Command {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'queue:add';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add an article in queue.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$id   = $this->argument('id');
		$type = $this->argument('type');

		$article = Article::findOrFail($id);

		if ($type === 'img' || $type === 'both') {
			Queue::push('ImagesHandler', array('id' => $id));
		}

		if ($type === 'info' || $type === 'both') {
			Queue::push('UrlInformationsHandler', array('id' => $id));
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			array('id', null, InputArgument::REQUIRED, 'Id of the article'),
			array('type', null, InputArgument::REQUIRED, 'img or info or both'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return array();
	}
}
