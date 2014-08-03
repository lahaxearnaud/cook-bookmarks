<?php

use Carbon\Carbon;

class LogsTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('logs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $dt      = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        $logs = array();

        for ($i = 0; $i < 10; $i++) {
            $logs[] = array(
                'user_id'    => round(rand(1, 2)),
                'url'        => route('api.v1.notes.index'),
                'route'      => 'api.v1.notes.index',
                'params'     => json_encode(array()),
                'method'     => 'GET',
                'httpCode'   => 200,
                'ip'         => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255),
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
            );
        }

        DB::table('logs')->insert($logs);
    }

}
