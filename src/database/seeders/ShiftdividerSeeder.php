<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ShiftdividerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shiftdivider')->insert([
            'store_id'=>'1',
            'time1'=>'10-23',
            'time2'=>'11-23',
            'time3'=>'10-17',
            'time4'=>'11-17',
            'time5'=>'15-23',
            'time6'=>'17-23',
            'time7'=>'18-23',
            'time8'=>'18.5-23',
            'time9'=>'19-23'
        ]);
    }
}
