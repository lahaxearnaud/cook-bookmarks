<?php

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        $dt      = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        $users = array(
            array(
                'username'          => 'admin',
                'email'             => 'admin@example.org',
                'password'          => Hash::make('admin'),
                'confirmation_code' => md5(microtime() . Config::get('app.key')),
                'created_at'        => $dateNow,
                'updated_at'        => $dateNow,
                'remember_token'    => 'azerty'
            ),
            array(
                'username'          => 'user',
                'email'             => 'user@example.org',
                'password'          => Hash::make('user'),
                'confirmation_code' => md5(microtime() . Config::get('app.key')),
                'created_at'        => $dateNow,
                'updated_at'        => $dateNow,
                'remember_token'    => 'azerty'

            )
        );

        DB::table('users')->insert($users);
    }

}
