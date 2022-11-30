<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'password'=>Hash::make('11111111'),
            'email'=>'11@gmail.com',
            "created_at" =>  Carbon::now(),
            "updated_at" =>  Carbon::now(),
        ]);

        DB::table('admins')->insert([
            'id'=>'2',
            'store_id'=>'2',
            'password'=>Hash::make('22222222'),
            'email'=>'22@gmail.com',
            "created_at" =>  Carbon::now(),
            "updated_at" =>  Carbon::now(),
        ]);

        DB::table('admins')->insert([
            'id'=>'3',
            'store_id'=>'3',
            'password'=>Hash::make('33333333'),
            'email'=>'33@gmail.com',
            "created_at" =>  Carbon::now(),
            "updated_at" =>  Carbon::now(),
        ]);
        
    }
}
