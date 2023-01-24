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
            'main'=>'10-23',
            'sub1'=>'11-23'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'11-23',
            'sub1'=>'10-17',
            'sub2'=>'17-23'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'10-17',
            'sub1'=>'11-17'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'11-17'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'15-23',
            'sub1'=>'17-23'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'17-23',
            'sub1'=>'18-23'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'18-23',
            'sub1'=>'18.5-23'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'18.5-23',
            'sub1'=>'19-23'
        ]);
        DB::table('nextdivider')->insert([
            'store_id'=>'1',
            'main'=>'19-23'
        ]);

    }
}
