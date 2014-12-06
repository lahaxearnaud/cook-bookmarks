<?php

use Carbon\Carbon;
use Faker\Internet;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $dt      = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        $users = array(
            array(
                'username'       => 'admin',
                'email'          => Internet::email('admin'),
                'password'       => Hash::make('admin'),
                'created_at'     => $dateNow,
                'updated_at'     => $dateNow,
                'remember_token' => 'azerty'
            ),
            array(
                'username'       => 'user',
                'email'          => Internet::email('user'),
                'password'       => Hash::make('user'),
                'created_at'     => $dateNow,
                'updated_at'     => $dateNow,
                'remember_token' => 'azerty'

            )
        );

        DB::table('users')->insert($users);
    }

}
