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
                'age' => '30',
                'submissionrate' => '100',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中花子',
                'email' => 'tanakahanako@example.com',
                'password' => 'qwertytanaka',
                'weight' => '5',
                'store_id' => '1',
                'age' => '28',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
        ];
        foreach ($init_employees as $init_employee) {
            $employee = new Employee();
            $employee->name = $init_employee['name'];
            $employee->email = $init_employee['email'];
            $encrypted = Hash::make($init_employee['password']); //暗号化
            $employee->password = $encrypted;
            $employee->weight = $init_employee['weight'];
            $employee->store_id = $init_employee['store_id'];
            $employee->age = $init_employee['age'];
            $employee->submissionrate = $init_employee['submissionrate'];
            $employee->monthminworktime = $init_employee['monthminworktime'];
            $employee->monthmaxworktime = $init_employee['monthmaxworktime'];
            $employee->weekminworktime = $init_employee['weekminworktime'];
            $employee->weekmaxworktime = $init_employee['weekmaxworktime'];
            $employee->dayminworktime = $init_employee['dayminworktime'];
            $employee->daymaxworktime = $init_employee['daymaxworktime'];
            $employee->save();
        }
        //parttimerのテストデータ
        $init_parttimers = [
            [
                'name' => '鈴木田中',
                'email' => 'suzukitanaka@example.com',
                'password' => 'qwertysuzuki',
                'weight' => '1',
                'store_id' => '1',
                'age' => '19',
                'submissionrate' => '0',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中鈴木',
                'email' => 'tanakasuzuki@example.com',
                'password' => 'qwertytanaka',
                'weight' => '1',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],

        ];
        foreach ($init_parttimers as $init_parttimer) {
            $parttimer = new Parttimer();
            $parttimer->name = $init_parttimer['name'];
            $parttimer->email = $init_parttimer['email'];
            //$parttimer->password=Hash::make($init_parttimer['password']);
            $encrypted = Hash::make($init_parttimer['password']); //暗号化
            $parttimer->password = $encrypted;
            $parttimer->weight = $init_parttimer['weight'];
            $parttimer->store_id = $init_parttimer['store_id'];
            $parttimer->age = $init_employee['age'];
            $parttimer->submissionrate = $init_parttimer['submissionrate'];
            $parttimer->monthminworktime = $init_parttimer['monthminworktime'];
            $parttimer->monthmaxworktime = $init_parttimer['monthmaxworktime'];
            $parttimer->weekminworktime = $init_parttimer['weekminworktime'];
            $parttimer->weekmaxworktime = $init_parttimer['weekmaxworktime'];
            $parttimer->dayminworktime = $init_parttimer['dayminworktime'];
            $parttimer->daymaxworktime = $init_parttimer['daymaxworktime'];
            $parttimer->save();
        }
    }
}
