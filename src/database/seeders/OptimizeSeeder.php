<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class OptimizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('optimize')->insert([
            'store_id'=>'1',
            'main_attendance'=>'10',
            'main_leaving'=>'23',
            'sub1_attendance'=>'11',
            'sub1_leaving'=>'23',
        ]);
        DB::table('optimize')->insert([
            'store_id'=>'1',
            'main_attendance'=>'10',
            'main_leaving'=>'17',
            'sub1_attendance'=>'11',
            'sub1_leaving'=>'17',
        ]);
        DB::table('optimize')->insert([
            'store_id'=>'1',
            'main_attendance'=>'15',
            'main_leaving'=>'23',
            'sub1_attendance'=>'17',
            'sub1_leaving'=>'23',
        ]);
        DB::table('optimize')->insert([
            'store_id'=>'1',
            'main_attendance'=>'10',
            'main_leaving'=>'23',
            'sub1_attendance'=>'10',
            'sub1_leaving'=>'17',
            'sub2_attendance'=>'17',
            'sub2_leaving'=>'23',
        ]);
    }
}
