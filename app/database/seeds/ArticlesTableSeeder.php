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

        $dt       = Carbon::now();
        $dateNow  = $dt->toDateTimeString();
        $articles = array();

        for ($i = 0; $i < 30; $i++) {
            $title      = Lorem::sentence(6);
            $body       = Lorem::paragraph(10);
            $articles[] = array(
                'author_id'  => round(rand(1, 2)),
                'title'      => $title,
                'url'        => 'http://github.com',
                'slug'       => Internet::slug($i . '-' . $title),
                'indexable'  => $body,
                'body'       => $body,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
                'category_id'=> round(rand(1, 10)),
            );
        }

        DB::table('articles')->insert($articles);
    }

}
