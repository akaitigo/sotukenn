<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notices')->insert([
            'store_id'=>'1',
            'content'=>'シフト期限',
            'target'=>'シフト未提出者',
            "message" =>'シフトを提出してください',
            "noticeday" => '17',
        ]);
        DB::table('notices')->insert([
            'store_id'=>'1',
            'content'=>'欠勤者が出ました',
            'target'=>'勤務可能者',
            "message" =>'シフト調整にご協力ください',
            "noticeday" => '0',
        ]);
        DB::table('notices')->insert([
            'store_id'=>'2',
            'content'=>'シフト期限',
            'target'=>'シフト未提出者',
            "message" =>'シフトを提出してください',
            "noticeday" => '15',
        ]);
    }
}
