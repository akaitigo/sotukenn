<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\Status;
use App\Models\CompleteShift;
use Illuminate\Http\Request;


class ShiftController extends Controller
{

    private $formItems = ["workstarttime", "workendtime", "submissionlimit","vote"];

    
     /* 提出シフト管理 */
    public function management()
    {
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();

        $allempid = [];
        $allempname = [];
        $submitcompempid = [];
        $submitcompempname = [];
        $allpartid = [];
        $allpartname = [];
        $submitcomppartid = [];
        $submitcomppartname = [];

        foreach($employees as $emp){
            $allempid[] = $emp->id;
            $allempname[] = $emp->name;
            foreach($emp-> Statuses as $status){
                    if($status->id == 4){
                        $submitcompempid[] = $emp->id;
                        $submitcompempname[] = $emp->name;
                    }
            }
        }
        foreach($parttimers as $part){
            $allpartname[] = $part->name;
            foreach($part-> Statuses as $status){
                    if($status->id == 4){
                        $submitcomppartid[] = $part->id;
                        $submitcomppartname[] = $part->name;
                    }
            }
        }

        $notsubmitempname = array_diff($allempname,$submitcompempname);
        $notsubmitpartname = array_diff($allpartname,$submitcomppartname);

        return view('submittedShift', compact('employees', 'parttimers','submitcompempid','submitcomppartid','submitcompempname','notsubmitempname','submitcomppartname','notsubmitpartname'));
    }

    /* シフト設定 */
    public function firstsetting(Request $request)
    {

        $data = $request->only($this->formItems);
        $vote=$request->input('vote');
        if(is_null($vote) ){
            $data['vote'] = 0;
        }else{
            $data['vote'] = 1;
        }
        /*認証コード*/
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        \DB::table('stores')
            ->where('id', $storeid)
            ->update([
                'workstarttime' => $data['workstarttime'],
                'workendtime' => $data['workendtime'],
                'submissionlimit' => $data['submissionlimit'],
                'vote' => $data['vote']     
            ]);

        return view('calendar');
    }

    /* 提出済みシフト確認 */
    public function detail()
    {
    }

    /* シフト閲覧 */
    public function view()
    {


        return view('shiftView');
    }

    /* シフト編集 */
    public function edit()
    {
        $adminid=Auth::guard('admin')->id();
        $employeeid=Auth::guard('employee')->id();
        $parttimerid=Auth::guard('parttimer')->id();
        $loginid = 0;
        $empjudge = 0;
        if(isset($adminid)) {
            $storeid = admin::where('id',$adminid)->value('store_id');
        }elseif(isset($employeeid)) {
            $storeid = Employee::where('id',$employeeid)->value('store_id');
            $loginid = $employeeid;
            $empjudge = true;
        }elseif(isset($parttimerid)) {
            $storeid = Parttimer::where('id',$parttimerid)->value('store_id');
            $loginid = $parttimerid;
            $empjudge = false;
        }

        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
        $completeshift = CompleteShift::where('store_id',$storeid)->get();

        $empname = [];
        $partname = [];

        foreach($completeshift as $compshift) {
            if($compshift->judge == true) {
                $empname[] = Employee::where('id',$compshift->emppartid)->value('name');
            }else {
                $partname[] = Parttimer::where('id',$compshift->emppartid)->value('name');
            }
        }

        $week = ['日','月','火','水','木','金','土'];

        return view('shiftEdit',compact('employees','parttimers','empname','partname','completeshift','loginid','empjudge','week'));
    }

    /* シフト作成メニュー */
    public function menu()
    {
        return view('shiftCreateMenu');
    }

    
    /* シフト作成 */
    public function create()
    {
        return view('shiftCreate');
    }

    /* シフト候補表示 */
    public function multiple()
    {
        return view('candidacyView');
    }

    /* シフト候補詳細 */
    public function choice()
    {
        return view('candidacyShiftChoice');
    }

}