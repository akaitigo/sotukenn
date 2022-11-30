<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_status')->insert([
            'employee_id' => '1',
            'status_id'=>'1',
            ]);
        DB::table('employee_status')->insert([
            'employee_id' => '1',
            'status_id'=>'2',
            ]);
        DB::table('employee_status')->insert([
            'employee_id' => '1',
            'status_id'=>'3',
            ]);
        DB::table('employee_status')->insert([
            'employee_id' => '1',
            'status_id'=>'4',
            ]);    
        DB::table('employee_status')->insert([
            'employee_id' => '2',
            'status_id'=>'1',
            ]);
        DB::table('employee_status')->insert([
            'employee_id' => '2',
            'status_id'=>'2',
            ]);
        DB::table('employee_status')->insert([
            'employee_id' => '2',
            'status_id'=>'3',
            ]);
        DB::table('employee_status')->insert([
            'employee_id' => '2',
            'status_id'=>'4',
            ]);

    }
}