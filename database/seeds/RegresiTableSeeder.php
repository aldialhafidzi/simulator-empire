<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegresiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            DB::table('regresi')->insert([
                'x' => mt_rand(60, 100),
                'y' => mt_rand(60, 100)
            ]);
        }
    }
}
