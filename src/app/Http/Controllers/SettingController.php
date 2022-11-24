<?php

namespace App\Http\Controllers;
use App\Models\Store;

use Illuminate\Http\Request;

class SettingController extends Controller
{

    private $formItems = ["workstarttime", "workendtime", "submissionlimit","vote"];


    public function update(Request $request){

        $data = $request->only($this->formItems);

        if($data['vote'] == null ){
            $data['vote'] = 0;
        }else{
            $data['vote'] = 1;
        }

        \DB::table('stores')
            ->where('id', 1)
            ->update([
                'workstarttime' => $data['workstarttime'],
                'workendtime' => $data['workendtime'],
                'submissionlimit' => $data['submissionlimit'],
                'vote' => $data['vote']
                
            ]);
    }
}
