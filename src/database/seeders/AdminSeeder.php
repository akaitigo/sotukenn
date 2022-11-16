<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id'=>'1',
            'store_id'=>'1',
            'password'=>'11111111',
            'mail'=>'11@gmail.com'
        ]);

        DB::table('admins')->insert([
            'id'=>'2',
            'store_id'=>'2',
            'password'=>'22222222',
            'mail'=>'22@gmail.com'
        ]);

        DB::table('admins')->insert([
            'id'=>'3',
            'store_id'=>'3',
            'password'=>'33333333',
            'mail'=>'33@gmail.com'
        ]);
        
    }
}
