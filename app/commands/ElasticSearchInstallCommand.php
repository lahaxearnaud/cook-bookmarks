<?php

use Illuminate\Console\Command;

class ElascticSearchInstallCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'es:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build index and add types in Elastic Search';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $params['index'] = Config::get('app.index');

        Es::indices()->create($params);
        $this->info('Create index ' . $params['index']);

        // add mapping
        $params['type'] = strtolower(get_class(new Article()));

        // Adding a new type to an existing index
        $postMapping                     = array(
            '_source'    => array(
                'enabled' => true
            ),

            'properties' => array(
                'title'        => array(
                    'type'     => 'string',
                    'analyzer' => 'standard',
                    'boost'    => 10.0
                ),
                'image'        => array(
                    'type'  => 'string',
                    'boost' => 0
                ),
                'author'       => array(
                    'type'     => 'string',
                    'analyzer' => 'standard',
                    'boost'    => 5.0
                ),
                'notes'        => array(
                    'type'     => 'string',
                    'analyzer' => 'standard',
                    'boost'    => 6.0
                ),
                'category'     => array(
                    'type'     => 'string',
                    'analyzer' => 'standard',
                    'boost'    => 1
                ),
                'category_id'  => array(
                    'type'     => 'integer',
                    'analyzer' => 'standard',
                    'boost'    => 1
                ),
                'indexable'    => array(
                    'type'     => 'string',
                    'analyzer' => 'standard',
                    'boost'    => 8.0
                ),
                'user'         => array(
                    'type'     => 'integer',
                    'analyzer' => 'standard',
                    'boost'    => 3
                ),
                'autocomplete' => array(
                    'type'                         => 'completion',
                    "index_analyzer"               => "standard",
                    "search_analyzer"              => "standard",
                    "preserve_position_increments" => false,
                    "preserve_separators"          => false,
                    "payloads"                     => true
                )
            )
        );
        $params['body'][$params['type']] = $postMapping;

        // Update the index mapping
        Es::indices()->putMapping($params);
        $this->info('Create type ' . $params['type']);

        $articles = App::make('ArticlesRepository')->all();
        $indexer  = new ArticleIndexer();

        foreach ($articles as $article) {
            $indexer->add($article);
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
