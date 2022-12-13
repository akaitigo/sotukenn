<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
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

        if($vote == "true"){
            $vote2 = 1;
        }else{
            $vote2 = 0;
        }


        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        if($workstarttime == 0 && $workendtime == 0 && $submissionlimit == 4 && $vote2 == 0) {

        }else {
            \DB::table('stores')
                ->where('id', $storeid)
                ->update([
                    'workstarttime' => $workstarttime,
                    'workendtime' => $workendtime,
                    'submissionlimit' => $submissionlimit,
                    'vote' => $vote2     
                ]);
        }

        return;
    }

    public function select(Request $request){
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $submitlimit = Store::where('id',$storeid)->value('submissionlimit');
        $stores = Store::find($storeid);   
        $workstarttime = Store::where('id',$storeid)->value('workstarttime'); 
        $workendtime = Store::where('id',$storeid)->value('workendtime');
        $submissionlimit = Store::where('id',$storeid)->value('submissionlimit');
        $vote = Store::where('id',$storeid)->value('vote');

        return response()->json([
            'workstarttime' => $workstarttime,
            'workendtime' => $workendtime,
            'submissionlimit' => $submissionlimit,
            'vote' => $vote
        ]);
    }
}
