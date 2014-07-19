<?php

use \Faker\Lorem;


class CategoriesTableSeeder extends Seeder {

	public function run()
	{

		foreach(range(1, 10) as $index)
		{
			Category::create([
                'user_id'  => round(rand(1, 2)),
                'name' => Lorem::word(rand(1, 4)),
			]);
		}
	}

}