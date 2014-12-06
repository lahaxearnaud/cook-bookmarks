<?php

use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{

    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        $dt         = Carbon::now();
        $dateNow    = $dt->toDateTimeString();
        $categories = array();

        $categories[] = [
            'user_id'    => 1,
            'name'       => 'Plat',
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'color'      => '#2ecc71'
        ];

        $categories[] = [
            'user_id'    => 1,
            'name'       => 'Dessert',
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'color'      => '#d35400'
        ];

        $categories[] = [
            'user_id'    => 1,
            'name'       => 'Soupe',
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'color'      => '#2980b9'
        ];

        $categories[] = [
            'user_id'    => 1,
            'name'       => 'Pâte',
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'color'      => '#E87E04'
        ];

        $categories[] = [
            'user_id'    => 1,
            'name'       => 'Boisson',
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'color'      => '#86E2D5'
        ];

        $categories[] = [
            'user_id'    => 1,
            'name'       => 'Sauce',
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'color'      => '#1E8BC3'
        ];

        DB::table('categories')->insert($categories);
    }

}
