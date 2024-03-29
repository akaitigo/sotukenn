<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParttimerJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parttimer_job')->insert([
            'parttimer_id' => '1',
            'job_id' => '1',
        ]);
        DB::table('parttimer_job')->insert([
            'parttimer_id' => '2',
            'job_id' => '1',
        ]);
        DB::table('parttimer_job')->insert([
            'parttimer_id' => '3',
            'job_id' => '1',
        ]);
        DB::table('parttimer_job')->insert([
            'parttimer_id' => '4',
            'job_id' => '2',
        ]);
    }
}
