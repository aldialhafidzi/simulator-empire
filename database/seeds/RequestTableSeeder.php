<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            DB::table('request')->insert([
                'days_to' => $i + 1,
                'qty' => mt_rand(0, 4)
            ]);
        }
    }
}
