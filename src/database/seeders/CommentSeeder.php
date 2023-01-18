<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment')->insert([
            'emppartid'=>'1',
            'store_id'=>'1',
            'judge'=>true,
            'month'=>'1',
            'comment1'=>'1',
            'comment2'=>'-1',
            'comment3'=>'1',
            'comment4'=>'1',
            'comment5'=>'1',
            'comment6'=>'1',
            'comment7'=>'1',
            'comment8'=>'1',
            'comment9'=>'1',
            'comment10'=>'1',
            'comment11'=>'-1',
            'comment12'=>'-1',
            'comment13'=>'17-23',
            'comment14'=>'-1',
            'comment15'=>'-1',
            'comment16'=>'11-23	',
            'comment17'=>'17-23',
            'comment18'=>'-1',
            'comment19'=>'10-23',
            'comment20'=>'10-23',
            'comment21'=>'17-23',
            'comment22'=>'17-23',
            'comment23'=>'10-23',
            'comment24'=>'17-23',
            'comment25'=>'17-23',
            'comment26'=>'-1',
            'comment27'=>'-1',
            'comment28'=>'17-23',
            'comment29'=>'-1',
            'comment30'=>'-1',
            'comment31'=>'aaaa'
        ]);

        DB::table('comment')->insert([
            'emppartid'=>'2',
            'store_id'=>'1',
            'judge'=>true,
            'month'=>'1',
            'comment1'=>'1',
            'comment2'=>'-1',
            'comment3'=>'1',
            'comment4'=>'1',
            'comment5'=>'1',
            'comment6'=>'1',
            'comment7'=>'1',
            'comment8'=>'1',
            'comment9'=>'1',
            'comment10'=>'1',
            'comment11'=>'-1',
            'comment12'=>'-1',
            'comment13'=>'17-23',
            'comment14'=>'-1',
            'comment15'=>'-1',
            'comment16'=>'11-23	',
            'comment17'=>'17-23',
            'comment18'=>'-1',
            'comment19'=>'10-23',
            'comment20'=>'10-23',
            'comment21'=>'17-23',
            'comment22'=>'17-23',
            'comment23'=>'10-23',
            'comment24'=>'17-23',
            'comment25'=>'17-23',
            'comment26'=>'-1',
            'comment27'=>'-1',
            'comment28'=>'17-23',
            'comment29'=>'-1',
            'comment30'=>'-1',
            'comment31'=>'10-23'
        ]);

        DB::table('comment')->insert([
            'emppartid'=>'3',
            'store_id'=>'1',
            'judge'=>true,
            'month'=>'1',
            'comment1'=>'1',
            'comment2'=>'-1',
            'comment3'=>'1',
            'comment4'=>'1',
            'comment5'=>'1',
            'comment6'=>'1',
            'comment7'=>'1',
            'comment8'=>'1',
            'comment9'=>'1',
            'comment10'=>'1',
            'comment11'=>'-1',
            'comment12'=>'-1',
            'comment13'=>'17-23',
            'comment14'=>'-1',
            'comment15'=>'-1',
            'comment16'=>'11-23	',
            'comment17'=>'17-23',
            'comment18'=>'-1',
            'comment19'=>'10-23',
            'comment20'=>'10-23',
            'comment21'=>'17-23',
            'comment22'=>'17-23',
            'comment23'=>'10-23',
            'comment24'=>'17-23',
            'comment25'=>'17-23',
            'comment26'=>'-1',
            'comment27'=>'-1',
            'comment28'=>'17-23',
            'comment29'=>'-1',
            'comment30'=>'-1',
            'comment31'=>'10-23'
        ]);
    }
}
