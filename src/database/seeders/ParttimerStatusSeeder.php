<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParttimerStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parttimer_status')->insert([
            'parttimer_id' => '1',
            'status_id'=>'1',
            ]);
        DB::table('parttimer_status')->insert([
            'parttimer_id' => '1',
            'status_id'=>'2',
            ]);
        DB::table('parttimer_status')->insert([
            'parttimer_id' => '1',
            'status_id'=>'3',
            ]);
        DB::table('parttimer_status')->insert([
            'parttimer_id' => '2',
            'status_id'=>'1',
            ]);
        DB::table('parttimer_status')->insert([
            'parttimer_id' => '2',
            'status_id'=>'2',
            ]);
        DB::table('parttimer_status')->insert([
            'parttimer_id' => '2',
            'status_id'=>'3',
            ]);

    }
}
