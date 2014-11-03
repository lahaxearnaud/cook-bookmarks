<?php

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;

class DataMigrateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate seed from the old project.';

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
        if (!File::exists($this->argument('source'))) {
            throw new Exception("File " . $this->argument('source') . " not found", 1);
        }
        $this->info('Extract from ' . $this->argument('source'));

        $articles = File::get($this->argument('source'));
        $articles = explode("\n", $articles);
        $nbItems  = count($articles);
        if ($nbItems === 0) {
            $this->info('Rows must be separe by \n and fields bu \t');
            throw new Exception("No data in " . $this->argument('source'), 1);
        }

        $progress = new ProgressBar($this->output, $nbItems);
        $progress->start();

        $extractor = new ArticleExtractor();
        $markdown  = new HTML_To_Markdown();
        $markdown->set_option('strip_tags', true);

        $dt          = Carbon::now();
        $currentDate = $dt->toDateTimeString();
        $seeds       = [];
        foreach ($articles as $key => $article) {
            $article = explode("\t", $article);

            if (!empty($article[8])) {
                $article[8] = 'http://' . $article[8];
            }

            if (!empty($article[8]) && filter_var($article[8], FILTER_VALIDATE_URL) !== false && empty($article[2])) {
                $result     = $extractor->extractFromRemote($article[8]);
                $article[2] = $markdown->convert($result['body']);
            } elseif (!empty($article[2])) {
                $article[2] = str_replace('↵', '', $markdown->convert(html_entity_decode($article[2])));
            }

            $seeds[$key] = [
                'title'       => $article[1],
                'slug'        => Str::slug($article[1]),
                'image'       => $article[10],
                'body'        => $article[2],
                'author_id'   => 4,
                'indexable'   => $article[2],
                'url'         => $article[8],
                'category_id' => $article[6]-$this->argument('category-delta'),
                'created_at'  => $currentDate,
                'updated_at'  => $currentDate,
            ];

            $progress->advance();
            unset($articles[$key]);
        }

        $progress->finish();
        $this->info('');
        $this->info('Write extract to ' . $this->argument('output'));
        File::put($this->argument('output'), '<?php $articles = ' . var_export($seeds, true) . ';');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('source', null, InputArgument::OPTIONAL, app_path('../data.txt'), 'Old file in CSV format (\t beetween fields and \n beetween lines)'),
            array('output', null, InputArgument::OPTIONAL, app_path('../seeder.php'), 'Output file'),
            array('category-delta', null, InputArgument::OPTIONAL, 4, 'Category mapping'),
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
