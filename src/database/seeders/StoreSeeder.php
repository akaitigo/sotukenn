<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
<<<<<<< HEAD
            'id' => '1',
            'store_name' => 'しょーまカンパニー',
            'workstarttime' => '10',
            'workendtime' => '22',
            'submissionlimit' => '1',
            'vote' => false
        ]);

        DB::table('stores')->insert([
            'id' => '2',
            'store_name' => 'まるおカンパニー',
            'workstarttime' => '10',
            'workendtime' => '22',
            'submissionlimit' => '1',
            'vote' => false
        ]);

        DB::table('stores')->insert([
            'id' => '3',
            'store_name' => 'ひかるカンパニー',
            'workstarttime' => '10',
            'workendtime' => '22',
            'submissionlimit' => '1',
            'vote' => false
=======
            'id'=>'1',
            'store_name'=>'しょーまカンパニー',
            'workstarttime'=>'10',
            'workendtime'=>'22',
            'vote'=>'0'
        ]);

        DB::table('stores')->insert([
            'id'=>'2',
            'store_name'=>'まるおカンパニー',
            'workstarttime'=>'10',
            'workendtime'=>'22',
            'vote'=>'0'
        ]);

        DB::table('stores')->insert([
            'id'=>'3',
            'store_name'=>'ひかるカンパニー',
            'workstarttime'=>'10',
            'workendtime'=>'22',
            'vote'=>'0'
>>>>>>> 33caf6bea215bd58c0ee76244dd286973dfca225
        ]);
        
    }
}
