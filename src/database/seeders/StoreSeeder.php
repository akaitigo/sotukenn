<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([

            'store_name' => 'MARUOカンパニー',
            'workstarttime' => '10',
            'workendtime' => '22',
            'submissionlimit' => null,
            'vote' => false
        ]);



        DB::table('stores')->insert([

            'store_name' => 'しょーまカンパニー',
            'workstarttime' => '10',
            'workendtime' => '22',
            'submissionlimit' => null,
            'vote' => false
        ]);

        DB::table('stores')->insert([

            'store_name' => 'ひかるカンパニー',
            'workstarttime' => '10',
            'workendtime' => '22',
            'submissionlimit' => null,
            'vote' => false

        ]);
    }
}
