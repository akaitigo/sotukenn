<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parttimer;
use App\Models\Employee;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

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
        $init_employees = [
            [
                'name' => '田中太郎',
                'email' => 'tanaka@example.com',
                'employee_id' => '1',
                'password' => 'qwertytanaka',
                'weight' => '5',
                'store_id' => '1',
            ],
            [
                'name' => '田中花子',
                'email' => 'tanakahanako@example.com',
                'employee_id' => '1',
                'password' => 'qwertytanaka',
                'weight' => '5',
                'store_id' => '1',
            ],
        ];
        foreach ($init_employees as $init_employee) {
            $employee = new Employee();
            $employee->name = $init_employee['name'];
            $employee->email = $init_employee['email'];
            $encrypted = Crypt::encryptString($init_employee['password']); //暗号化
            $employee->password = $encrypted;
            $employee->weight = $init_employee['weight'];
            $employee->store_id = $init_employee['store_id'];
            $employee->save();
        }
        //parttimerのテストデータ
        $init_parttimers = [
            [
                'name' => '鈴木田中',
                'employee_id' => '1',
                'password' => 'qwertysuzuki',
                'weight' => '1'
            ],
            [
                'name' => '田中鈴木',
                'employee_id' => '1',
                'password' => 'qwertytanaka',
                'weight' => '1'
            ],

        ];
        foreach ($init_parttimers as $init_parttimer) {
            $parttimer = new Parttimer();
            $parttimer->name = $init_parttimer['name'];
            $parttimer->employee_id = $init_parttimer['employee_id'];
            //$parttimer->password=Hash::make($init_parttimer['password']);
            $encrypted = Crypt::encryptString($init_parttimer['password']); //暗号化
            $parttimer->password = $encrypted;
            $parttimer->weight = $init_parttimer['weight'];
            $parttimer->save();
        }
    }
}
