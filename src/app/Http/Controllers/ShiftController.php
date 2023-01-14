<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\Status;
use App\Models\CompleteShift;
use App\Models\StaffShift;
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
        $staffcompleteshift = CompleteShift::where('emppartid',$loginid)->where('judge',$empjudge)->get();
        $privatestaffshift = StaffShift::where('emppartid',$loginid)->where('judge',$empjudge)->get();

        $empname = [];
        $partname = [];
        $i = 0;

        //社員を配列格納　労働時間と日数計算
        foreach($completeshift as $compshift) {
            if($compshift->judge == true) {
                $empname[] = Employee::where('id',$compshift->emppartid)->value('name');
            }else {
                $partname[] = Parttimer::where('id',$compshift->emppartid)->value('name');
            }

            (double)$StaffTime = 0;
            (double)$StaffsumTime = 0;
            $Staffworkday = 0;

            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;

                if($compshift->$hentai != "×" && $compshift->$hentai != "-") {
                    (int)$num1 = strpos($compshift->$hentai,"-");//出勤、退勤抜き出しに使用
                    (double)$in1 =  (double) substr($compshift->$hentai,0,$num1);//提出シフトの出勤時間抜き出し
                    (double)$out1 =  (double) substr($compshift->$hentai,$num1 + 1);//提出シフトの退勤時間抜き出し
                    $StaffTime = $out1 - $in1;
                    $StaffsumTime = $StaffsumTime + $StaffTime;
                    $Staffworkday++;
                }
            }
            $StaffTimes[$i] = $StaffsumTime;
            $Staffworkdays[$i] = $Staffworkday;
            $i++;
        }

        $staffshiftcompleteworkday = 0;
        $staffshiftworkday = 0;
        (int)$staffshiftcover = 0;

        foreach($staffcompleteshift as $staffcompshift) {
            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;
                if($staffcompshift->$hentai != "×" && $staffcompshift->$hentai != "-") {
                    $staffshiftcompleteworkday++;
                }
            }
        }

        foreach($privatestaffshift as $staffshift) {
            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;
                if($staffshift->$hentai != "-1") {
                    $staffshiftworkday++;
                }
            }
        }

        if($loginid != 0) {                               //これないとバグる
            if($staffshiftcompleteworkday == 0 || $staffshiftworkday == 0){
                $staffshiftcover = 0;
            }else{
                (int)$staffshiftcover = ($staffshiftcompleteworkday / $staffshiftworkday) *100;
                $staffshiftcover = round($staffshiftcover,0);
                if($staffshiftcover >= 100) {
                    $staffshiftcover = 100;
                }
            }
        }

        $week = ['日','月','火','水','木','金','土'];

        return view('new_shiftView',compact('employees','parttimers','empname','partname','completeshift','loginid','empjudge','Staffworkdays','StaffTimes','staffshiftcover','week'));
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
        $i = 0;

        foreach($completeshift as $compshift) {
            if($compshift->judge == true) {
                $empname[] = Employee::where('id',$compshift->emppartid)->value('name');
            }else {
                $partname[] = Parttimer::where('id',$compshift->emppartid)->value('name');
            }

            (double)$StaffTime = 0;
            (double)$StaffsumTime = 0;
            $Staffworkday = 0;

            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;

                if($compshift->$hentai != "×" && $compshift->$hentai != "-") {
                    (int)$num1 = strpos($compshift->$hentai,"-");//出勤、退勤抜き出しに使用
                    (double)$in1 =  (double) substr($compshift->$hentai,0,$num1);//提出シフトの出勤時間抜き出し
                    (double)$out1 =  (double) substr($compshift->$hentai,$num1 + 1);//提出シフトの退勤時間抜き出し
                    $StaffTime = $out1 - $in1;
                    $StaffsumTime = $StaffsumTime + $StaffTime;
                    $Staffworkday ++;
                }
            }

            $StaffTimes[$i] = $StaffsumTime;
            $Staffworkdays[$i] = $Staffworkday;
            $i++;
        }

        $emppartcount = $i + 1;
        $week = ['日','月','火','水','木','金','土'];

        return view('shiftEdit',compact('employees','parttimers','empname','partname','completeshift','loginid','empjudge','Staffworkdays','StaffTimes','week','emppartcount'));
    }


    /* シフト編集上書き処理 */
    public function update(Request $request)
    {

        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $completeshift = CompleteShift::where('store_id',$storeid)->get();
        $emppartcount = 0;
        foreach($completeshift as $compshift) {
            $emppartcount++;
        }

        foreach($completeshift as $compshift) {
            for ($day = 1; $day <= 31; $day++){
                $hentai = 'day' . $day; 
                $shifttext = $compshift->id . '-' . $day;
                $inputshifttext = $request->input($shifttext);
                \DB::table('complete_shifts')
                ->where('id', $compshift->id)
                ->update([
                     $hentai => $inputshifttext
                ]);
            }
        }

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
        $staffcompleteshift = CompleteShift::where('emppartid',$loginid)->where('judge',$empjudge)->get();
        $privatestaffshift = StaffShift::where('emppartid',$loginid)->where('judge',$empjudge)->get();

        $empname = [];
        $partname = [];
        $i = 0;

        //社員を配列格納　労働時間と日数計算
        foreach($completeshift as $compshift) {
            if($compshift->judge == true) {
                $empname[] = Employee::where('id',$compshift->emppartid)->value('name');
            }else {
                $partname[] = Parttimer::where('id',$compshift->emppartid)->value('name');
            }

            (double)$StaffTime = 0;
            (double)$StaffsumTime = 0;
            $Staffworkday = 0;

            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;

                if($compshift->$hentai != "×" && $compshift->$hentai != "-") {
                    (int)$num1 = strpos($compshift->$hentai,"-");//出勤、退勤抜き出しに使用
                    (double)$in1 =  (double) substr($compshift->$hentai,0,$num1);//提出シフトの出勤時間抜き出し
                    (double)$out1 =  (double) substr($compshift->$hentai,$num1 + 1);//提出シフトの退勤時間抜き出し
                    $StaffTime = $out1 - $in1;
                    $StaffsumTime = $StaffsumTime + $StaffTime;
                    $Staffworkday++;
                }
            }
            $StaffTimes[$i] = $StaffsumTime;
            $Staffworkdays[$i] = $Staffworkday;
            $i++;
        }

        $staffshiftcompleteworkday = 0;
        $staffshiftworkday = 0;
        (int)$staffshiftcover = 0;

        foreach($staffcompleteshift as $staffcompshift) {
            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;
                if($staffcompshift->$hentai != "×" && $staffcompshift->$hentai != "-") {
                    $staffshiftcompleteworkday++;
                }
            }
        }

        foreach($privatestaffshift as $staffshift) {
            for($day= 1; $day <= 31; $day++) {
                $hentai="day".$day;
                if($staffshift->$hentai != "-1") {
                    $staffshiftworkday++;
                }
            }
        }

        if($loginid != 0) {                               //これないとバグる
            if($staffshiftcompleteworkday == 0 || $staffshiftworkday == 0){
                $staffshiftcover = 0;
            }else{
                (int)$staffshiftcover = ($staffshiftcompleteworkday / $staffshiftworkday) *100;
                $staffshiftcover = round($staffshiftcover,0);
                if($staffshiftcover >= 100) {
                    $staffshiftcover = 100;
                }
            }
        }

        $week = ['日','月','火','水','木','金','土'];

        return redirect()->route('new_shiftView')->with(compact('employees','parttimers','empname','partname','completeshift','loginid','empjudge','Staffworkdays','StaffTimes','staffshiftcover','week'));
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