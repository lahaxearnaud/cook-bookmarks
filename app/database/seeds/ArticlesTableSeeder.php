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

        $urls = [
            'http://www.marmiton.org/recettes/recette_paupiettes-de-veau-aux-oignons-et-tomates_17872.aspx',
            'http://www.cuisineaz.com/recettes/spaghetti-meatballs-67007.aspx',
            'http://www.cuisineaz.com/recettes/joues-de-boeuf-mijotees-65203.aspx',
            'http://www.cuisineaz.com/recettes/spaghetti-aux-boulettes-et-a-la-sauce-tomate-62901.aspx',
            'http://www.cuisineaz.com/recettes/mafaldine-aux-boulettes-de-boeuf-sauce-tomate-59199.aspx',
            'http://www.cuisineaz.com/recettes/cannelloni-provencale-a-l-italienne-40478.aspx',
            'http://www.cuisineaz.com/recettes/boulettes-de-boeuf-hache-a-la-sauce-tomate-11591.aspx',
            'http://www.cuisineaz.com/recettes/spaghetti-aux-tomates-fraiches-3037.aspx',
            'http://www.cuisineaz.com/recettes/spaghetti-meatballs-67007.aspx'
        ];

        for ($i = 0; $i < 30; $i++) {
            $title      = Lorem::sentence(6);
            $body       = Lorem::paragraph(10);
            $articles[] = array(
                'author_id'  => round(rand(1, 2)),
                'title'      => $title,
                'url'        => $urls[rand(0, count($urls) - 1)],
                'slug'       => Internet::slug($i . '-' . $title),
                'indexable'  => $body,
                'body'       => $body,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
                'category_id'=> round(rand(1, 9)),
            );
        }

        DB::table('articles')->insert($articles);

        for ($i = 1; $i < 31; $i++) {
            \Queue::push('UrlInformationsHandler', array('id' => $i));
        }

    }

}
