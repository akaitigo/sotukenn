<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parttimer;
use App\Models\Employee;

class MultiAuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //employeeのテストデータ
        $init_employees=[
            [
                'name'=>'田中太郎',
                'email'=>'tanaka@example.com',
                'employee_id'=>'1',
                'password'=>'qwertytanaka',
                'weight'=>'5',
                'company_id'=>'1',
            ],
        ];
        foreach($init_employees as $init_employee){
            $employee = new Employee();
            $employee->name=$init_employee['name'];
            $employee->email=$init_employee['email'];
            $employee->password=Hash::make($init_employee['password']);
            $employee->weight=$init_employee['weight'];
            $employee->company_id=$init_employee['company_id'];
            $employee->save();
        }
        //parttimerのテストデータ
        $init_parttimers=[
            [
                'name'=>'鈴木田中',
                'email'=>'suzuki@example.com',
                'employee_id'=>'1',
                'password'=>'qwertysuzuki',
                'weight'=>'1'
            ],
        ];
        foreach($init_parttimers as $init_parttimer){
            $parttimer = new Parttimer();
            $parttimer->name=$init_parttimer['name'];
            $parttimer->email=$init_parttimer['email'];
            $parttimer->employee_id=$init_parttimer['employee_id'];
            $parttimer->password=Hash::make($init_parttimer['password']);
            $parttimer->weight=$init_parttimer['weight'];
            $parttimer->save();
        }

        
    }
}
