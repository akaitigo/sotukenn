<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_job')->insert([
            'employee_id' => '1',
            'job_id' => '1'
        ]);
        DB::table('employee_job')->insert([
            'employee_id' => '1',
            'job_id' => '2'
        ]);

        DB::table('employee_job')->insert([
            'employee_id' => '2',
            'job_id' => '1'
        ]);
    }
}
