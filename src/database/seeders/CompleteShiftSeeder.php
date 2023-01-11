<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompleteShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('complete_shifts')->insert([
            'emppartid'=>'1',
            'store_id'=>'1',
            'judge'=>true,
            'month'=>'1',
        ]);
    }
}
