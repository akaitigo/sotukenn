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
            //MARUOカンパニー
            [
                'name' => '田中太郎',
                'email' => 'test@test.com',
                'password' => 'test',
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
                'email' => '11@gmail.com',
                'password' => 'testtest',
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
            [
                'name' => '田中まさお',
                'email' => 'fdsafsafds@example.com',
                'password' => 'fdsafdsf',
                'weight' => '2',
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
            [
                'name' => '田中ゆの',
                'email' => 'sskjdjads@example.com',
                'password' => 'asdfdsfsdf',
                'weight' => '4',
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
            [
                'name' => '田中れん',
                'email' => 'hhh@example.com',
                'password' => 'hhhhhhhh',
                'weight' => '4',
                'store_id' => '1',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',

            ],
            [
                'name' => '田中りょうすけ',
                'email' => 'rrrr@example.com',
                'password' => 'rrrrrrrr',
                'weight' => '4',
                'store_id' => '1',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],

            //翔馬カンパニー
            [
                'name' => '田中しょーま',
                'email' => 'sssssss@example.com',
                'password' => 'ssssssss',
                'weight' => '4',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中まさき',
                'email' => 'mmm@example.com',
                'password' => 'mmmmmmmm',
                'weight' => '4',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中りゅうせい',
                'email' => 'nn@example.com',
                'password' => 'nnnnnnnn',
                'weight' => '4',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中なぎさ',
                'email' => 'll@example.com',
                'password' => 'llllllll',
                'weight' => '4',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中マルフォイ',
                'email' => 'surizarin@example.com',
                'password' => 'surizarinsaikooo',
                'weight' => '4',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中ポッター',
                'email' => 'potta@example.com',
                'password' => 'lovevoldemoto',
                'weight' => '4',
                'store_id' => '2',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            //ひかるカンパニー
            [
                'name' => '田中ひかる',
                'email' => 'hikaru@example.com',
                'password' => 'hikaruhikaru',
                'weight' => '4',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中小松',
                'email' => '555@example.com',
                'password' => 'hugumuzukatta',
                'weight' => '4',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中トリコ',
                'email' => 'toriko@example.com',
                'password' => 'gurumesupaisa',
                'weight' => '4',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中サニー',
                'email' => 'sani@example.com',
                'password' => 'kamisikakatan',
                'weight' => '4',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中ココ',
                'email' => 'koko@example.com',
                'password' => 'dokuwomottedokuwoseisu',
                'weight' => '4',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '80',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '田中ゼブラ',
                'email' => 'zebura@example.com',
                'password' => 'omaenomonohaorenomono',
                'weight' => '4',
                'store_id' => '3',
                'age' => '20',
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
            $employee->daymaxworktime = $init_employee['daymaxworktime'];

            $employee->save();
        }
        //parttimerのテストデータ
        $init_parttimers = [
            //MARUOカンパニー
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
                'name' => '鈴木りさ',
                'email' => 'tanakasuzuki@example.com',
                'password' => 'qwertytanaka',
                'weight' => '1',
                'store_id' => '1',
                'age' => '20',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木パンダ',
                'email' => 'panda@example.com',
                'password' => 'qwertytanaka',
                'weight' => '2',
                'store_id' => '1',
                'age' => '20',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木黄猿',
                'email' => 'kizaru@example.com',
                'password' => 'kizarumanzi',
                'weight' => '4',
                'store_id' => '1',
                'age' => '56',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木赤犬',
                'email' => 'akainu@example.com',
                'password' => 'akainumanzi',
                'weight' => '1',
                'store_id' => '1',
                'age' => '88',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木青雉',
                'email' => 'aokizi@example.com',
                'password' => 'aiceageee',
                'weight' => '2',
                'store_id' => '1',
                'age' => '24',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            //しょーまカンパニー
            [
                'name' => '鈴木ヴォルデモート',
                'email' => 'vol@example.com',
                'password' => 'pottalike',
                'weight' => '1',
                'store_id' => '2',
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
                'name' => '鈴木ハーマイオニー',
                'email' => 'ha-ma@example.com',
                'password' => 'reviosareviosa',
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
            [
                'name' => '鈴木ダンブルドア',
                'email' => 'danbulubulu@example.com',
                'password' => 'danbulubulu',
                'weight' => '2',
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
            [
                'name' => '鈴木スネイプ',
                'email' => 'suneipu@example.com',
                'password' => 'zituhaiiyatu',
                'weight' => '4',
                'store_id' => '2',
                'age' => '56',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木ロン',
                'email' => 'ron@example.com',
                'password' => 'ronronron',
                'weight' => '1',
                'store_id' => '2',
                'age' => '88',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木ルーナ',
                'email' => 'runa@example.com',
                'password' => 'hariharilovehari',
                'weight' => '2',
                'store_id' => '2',
                'age' => '24',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            // ひかるカンパニー
            [
                'name' => '鈴木一龍',
                'email' => 'itiryu@example.com',
                'password' => 'itibantuyoui',
                'weight' => '1',
                'store_id' => '3',
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
                'name' => '鈴木マンサム',
                'email' => 'mansamu@example.com',
                'password' => 'hansamunamansamu',
                'weight' => '1',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木次郎',
                'email' => 'zirou@example.com',
                'password' => 'nokkingumaster',
                'weight' => '2',
                'store_id' => '3',
                'age' => '20',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木トミーロッド',
                'email' => 'tommy@example.com',
                'password' => 'musikimoi',
                'weight' => '4',
                'store_id' => '3',
                'age' => '56',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木アカシア',
                'email' => 'akasia@example.com',
                'password' => 'akasiafullcose',
                'weight' => '1',
                'store_id' => '3',
                'age' => '88',
                'submissionrate' => '35',
                'monthminworktime' => '100.0',
                'monthmaxworktime' => '-1',
                'weekminworktime' => '20.5',
                'weekmaxworktime' => '-1',
                'dayminworktime' => '-1',
                'daymaxworktime' => '-1',
            ],
            [
                'name' => '鈴木ブリオン',
                'email' => 'burion@example.com',
                'password' => 'itibanninki',
                'weight' => '2',
                'store_id' => '3',
                'age' => '24',
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
            $parttimer->password = Hash::make($init_parttimer['password']);
            // $encrypted = Crypt::encryptString($init_parttimer['password']); //暗号化

            //$parttimer->password=Hash::make($init_parttimer['password']);
            $encrypted = Hash::make($init_parttimer['password']); //暗号化


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
