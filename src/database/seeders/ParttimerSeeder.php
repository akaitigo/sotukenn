<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParttimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parttimers')->insert([
            'employee_id' => '1',
            'parttimer_name' => 'バイト太郎',
            'parttimer_pass' => 'qwerty',
            'parttimer_weight' => '1',
        ]);
        DB::table('parttimers')->insert([
            'employee_id' => '1',
            'parttimer_name' => 'バイト花子',
            'parttimer_pass' => 'qwerty',
            'parttimer_weight' => '1',
        ]);
        DB::table('parttimers')->insert([
            'employee_id' => '1',
            'parttimer_name' => '佐藤パー助',
            'parttimer_pass' => 'qwerty',
            'parttimer_weight' => '1',
        ]);
        DB::table('parttimers')->insert([
            'employee_id' => '1',
            'parttimer_name' => '鈴木パー子',
            'parttimer_pass' => 'qwerty',
            'parttimer_weight' => '1',
        ]);
    }
}
