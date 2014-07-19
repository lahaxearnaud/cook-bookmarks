<?php

use \Faker\Lorem;
use Carbon\Carbon;


class CategoriesTableSeeder extends Seeder
{

    public function run ()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        $dt      = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        $categories = array();

        foreach (range(1, 10) as $index) {
            $categories[] = [
                'user_id'    => round(rand(1, 2)),
                'name'       => Lorem::word(rand(1, 4)),
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            ];
        }

        DB::table('categories')->insert($categories);
    }

}