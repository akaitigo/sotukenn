<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NextdividerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'10-17',
            'sub1'=>'11-17',
        ]);
    }
}
