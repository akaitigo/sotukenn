<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parttimer;
use App\Models\Employee;
use App\Models\Store;
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
                'password' => 'qwertytanaka',
                'weight' => '5',
                'store_id' => '1',
            ],
            [
                'name' => '田中花子',
                'email' => 'tanakahanako@example.com',
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
                'email' => 'suzukitanaka@example.com',
                'password' => 'qwertysuzuki',
                'weight' => '1',
                'store_id' => '1'
            ],
            [
                'name' => '田中鈴木',
                'email' => 'tanakasuzuki@example.com',
                'password' => 'qwertytanaka',
                'weight' => '1',
                'store_id' => '2'
            ],

        ];
        foreach ($init_parttimers as $init_parttimer) {
            $parttimer = new Parttimer();
            $parttimer->name = $init_parttimer['name'];
            $parttimer->email = $init_parttimer['email'];
            //$parttimer->password=Hash::make($init_parttimer['password']);
            $encrypted = Crypt::encryptString($init_parttimer['password']); //暗号化
            $parttimer->password = $encrypted;
            $parttimer->weight = $init_parttimer['weight'];
            $parttimer->store_id = $init_parttimer['store_id'];
            $parttimer->save();
        }
    }
}
