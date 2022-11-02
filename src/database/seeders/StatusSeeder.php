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
            'status_name'=>'高校生',
            ]);
        DB::table('statuses')->insert([
            'status_name'=>'既婚者',
        ]);
        DB::table('statuses')->insert([
            'status_name'=>'社会保険',
        ]);
    }
}
