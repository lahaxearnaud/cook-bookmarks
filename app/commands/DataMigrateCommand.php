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

        $data    = File::get($this->argument('source'));
        $data    = explode("\n", $data);
        $nbItems = count($data);
        if ($nbItems === 0) {
            $this->info('Rows must be separe by \n and fields bu \t');
            throw new Exception("No data in " . $this->argument('source'), 1);
        }

        $progress = new ProgressBar($this->output, $nbItems);
        $progress->start();

        $extractor = new ArticleExtractor();
        $markdown  = new HTML_To_Markdown();
        $markdown->set_option('strip_tags', true);

        $dt      = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        $results = [];
        foreach ($data as $key => $value) {
            $tmp = explode("\t", $value);

            if (!empty($tmp[8])) {
                $tmp[8] = 'http://' . $tmp[8];
            }

            if (!empty($tmp[8]) && filter_var($tmp[8], FILTER_VALIDATE_URL) !== false && empty($tmp[2])) {
                $result = $extractor->extractFromRemote($tmp[8]);
                $tmp[2] = $markdown->convert($result['body']);
            } elseif (!empty($tmp[2])) {
                $tmp[2] = str_replace('↵', '', $markdown->convert(html_entity_decode($tmp[2])));
            }

            $results[$key] = [
                'title'       => $tmp[1],
                'slug'        => Str::slug($tmp[1]),
                'image'       => $tmp[10],
                'body'        => $tmp[2],
                'author_id'   => 1,
                'indexable'   => $tmp[2],
                'url'         => $tmp[8],
                'author_id'   => 1,
                'category_id' => $tmp[6]-$this->argument('category-delta'),
                'created_at'  => $dateNow,
                'updated_at'  => $dateNow,
            ];

            $progress->advance();
            unset($data[$key]);
        }

        $progress->finish();
        $this->info('');
        $this->info('Write extract to ' . $this->argument('output'));
        File::put($this->argument('output'), '<?php $articles = ' . var_export($result, true) . ';');
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
