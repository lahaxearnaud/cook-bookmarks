<?php

use Illuminate\Console\Command;

class ElascticSearchUninstallCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'es:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete index Elastic Search';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $params['index'] = Config::get('app.index');
        try {
            Es::indices()->delete($params);
            $this->info('Delete index ');
        } catch (Exception $e) {
            $this->error('Unable to find or delete index ' . $params['index']);
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
