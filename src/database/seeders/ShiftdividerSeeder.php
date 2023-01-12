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
            'time2'=>'10-23',
            'time3'=>'10-23',
            'time4'=>'15-23',
            'time5'=>'15-23',
            'time6'=>'17-23',
            'time7'=>'10-23',
            'time8'=>'10-17',
            'time9'=>'10-23',
            'time10'=>'10-23',
            'time11'=>'10-23',
            'time12'=>'10-23',
            'time13'=>'18-23',
            'time14'=>'10-23',
            'time15'=>'10-23',
            'time16'=>'10-23',
            'time17'=>'17-23',
            'time18'=>'10-23',
            'time19'=>'15-23',
            'time20'=>'15-23',
            'time21'=>'10-23',
            'time22'=>'17-23',
            'time23'=>'17-23',
            'time24'=>'10-17',
            'time25'=>'10-17',
            'time26'=>'17-23',
            'time27'=>'17-23',
            'time28'=>'10-23',
            'time29'=>'10-23',
            'time30'=>'18-23',
        ]);
    }
}
