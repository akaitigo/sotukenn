<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\Status;
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
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $parttimers = Parttimer::where('store_id',$storeid)->get();

        $allempname = [];
        $submitcompempname = [];
        $allpartname = [];
        $submitcomppartname = [];

        foreach($employees as $emp){
            $allempname[] = $emp->name;
            foreach($emp-> Statuses as $status){
                    if($status->id == 4){
                        $submitcompempname[] = $emp->name;
                    }
            }
        }
        foreach($parttimers as $part){
            $allpartname[] = $part->name;
            foreach($part-> Statuses as $status){
                    if($status->id == 4){
                        $submitcomppartname[] = $part->name;
                    }
            }
        }

        $notsubmitempname = array_diff($allempname,$submitcompempname);
        $notsubmitpartname = array_diff($allpartname,$submitcomppartname);

        return view('submittedShift', compact('employees', 'parttimers','submitcompempname','notsubmitempname','submitcomppartname','notsubmitpartname'));
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
        return view('shiftEdit');
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