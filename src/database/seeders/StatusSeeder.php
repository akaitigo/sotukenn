<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name'=>'高校生',
            ]);
        DB::table('statuses')->insert([
            'name'=>'既婚者',
        ]);
        DB::table('statuses')->insert([
            'name'=>'社会保険',
        ]);
        DB::table('statuses')->insert([
            'name'=>'提出状態',
        ]);
    }
}
