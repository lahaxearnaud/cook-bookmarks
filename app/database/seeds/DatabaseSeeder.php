<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        $this->call('UsersTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('ArticlesTableSeeder');
        $this->call('NotesTableSeeder');
        $this->call('LogsTableSeeder');
    }

}
