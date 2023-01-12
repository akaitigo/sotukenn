<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeedShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('needshift')->insert([
            'store_id'=>'1',
            'day'=>'1',
            'time1'=>'10-23',
            'time2'=>'10-23',
            'time3'=>'10-23',
            'time4'=>'15-23',
            'time5'=>'15-23',
            'time6'=>'17-23',
            'time7'=>'10-23',
            'time8'=>'10-17'
        ]);
    }
}
