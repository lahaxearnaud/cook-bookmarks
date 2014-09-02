<?php

use Carbon\Carbon;
use \Faker\Lorem;
use \Faker\Internet;

class ArticlesTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('articles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        include app_path('../seeder.php');

        DB::table('articles')->insert($articles);

        for ($i = 1; $i < 31; $i++) {
            \Queue::push('UrlInformationsHandler', array('id' => $i));
        }

    }

}
