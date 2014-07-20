<?php

use Carbon\Carbon;
use \Faker\Lorem;
use \Faker\Internet;

class NotesTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('notes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $dt       = Carbon::now();
        $dateNow  = $dt->toDateTimeString();
        $notes = array();

        for ($i = 0; $i < 30; $i++) {
            $body      = Lorem::sentence(6);
            $notes[] = array(
                'user_id'  => round(rand(1, 2)),
                'article_id'=> round(rand(1, 9)),
                'body'       => $body,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            );
        }

        DB::table('notes')->insert($notes);
    }

}
