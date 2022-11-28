<?php

namespace App\Http\Controllers;
use App\Models\Store;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $formItems = ["workstarttime", "workendtime", "submissionlimit","vote"];    

    public function update(Request $request){

        //$data = $request->only($this->formItems);

        $workstarttime = $_POST['workstarttime'];
        $workendtime = $_POST['workendtime'];
        $submissionlimit = $_POST['submissionlimit'];
        $vote = $_POST['vote'];

        if(is_null($vote)){
            $vote2 = 1;
        }else{
            $vote2 = 0;
        }


        \DB::table('stores')
            ->where('id', 1)
            ->update([
                'workstarttime' => $workstarttime,
                'workendtime' => $workendtime,
                'submissionlimit' => $submissionlimit,
                'vote' => $vote2
                
            ]);

        return;
    }
}
