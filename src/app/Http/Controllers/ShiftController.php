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
use Carbon\Carbon;
use Yasumi\Yasumi;


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

    /* シフト閲覧 変える*/
    public function view()
    {
        $userId;
        $storeid;
        $empjudge=0;
        if(Auth::guard('admin')->check()){
            $userId = Auth::guard('admin')->id();
            $storeid=admin::where('id',$userId)->value('store_id');
            $userId = 0;
        }else if(Auth::guard('employee')->check()){
            $userId = Auth::guard('employee')->id();
            $storeid=Employee::where('id',$userId)->value('store_id');
            $empjudge = true;
        }else if(Auth::guard('parttimer')->check()){
            $userId = Auth::guard('parttimer')->id();
            $storeid=Parttimer::where('id',$userId)->value('store_id');
            $empjudge = false;
        }
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
        $completeshift = CompleteShift::where('store_id',$storeid)->get();
        $staffcompleteshift = CompleteShift::where('emppartid',$userId)->where('judge',$empjudge)->get();
        $privatestaffshift = StaffShift::where('emppartid',$userId)->where('judge',$empjudge)->get();

        $carbonNow = Carbon::now();
        $thisMonth = $carbonNow->month;
        $firstDay = $carbonNow->firstOfMonth()->day;
        $lastDate = $carbonNow->lastOfMonth()->day;
        $calendarData = [
            [
                'day'=>Carbon::now()->firstOfMonth()->dayOfWeek,
                'month'=>$thisMonth,
                'lastDay'=>$lastDate,
            ]
        ];
        //祝日を入れる
        $holidays = Yasumi::create('Japan', '2023', 'ja_JP');
        $holidaysInBetweenDays = $holidays->between(
            Carbon::now()->firstOfMonth(),
            Carbon::now()->lastOfMonth()
        );
        $array=['-'];
        for($i=1;$i<=$lastDate;$i++){
                array_push($array,'-');
        }
        foreach($holidaysInBetweenDays as $holiday) {
            $array[$holiday->format('j')] = $holiday->getName();
        }

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

            for($j= 1; $j <= 31; $j++) {
                $hentai="day".$j;

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
            for($j= 1; $j <= $lastDate; $j++) {
                $hentai="day".$j;
                if($staffcompshift->$hentai != "×" && $staffcompshift->$hentai != "-") {
                    $staffshiftcompleteworkday++;
                }
            }
        }

        foreach($privatestaffshift as $staffshift) {
            for($j= 1; $j <= $lastDate; $j++) {
                $hentai="day".$j;
                if($staffshift->$hentai != "-1") {
                    $staffshiftworkday++;
                }
            }
        }

        if($userId != 0) {                               //これないとバグる
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
        $loginid=$userId;
        return view('new_shiftView',compact('employees','parttimers','empname','partname','completeshift','userId','empjudge','Staffworkdays','StaffTimes','staffshiftcover','week','calendarData','array'));
    }

    /* シフト編集 変える*/
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
        $workstarttime = Store::where('id',$storeid)->value('workstarttime'); 
        $workendtime = Store::where('id',$storeid)->value('workendtime');
        $completeshift = CompleteShift::where('store_id',$storeid)->get();

        $empname = [];
        $partname = [];
        $emppartname = [];
        $i = 0;

        foreach($completeshift as $compshift) {
            if($compshift->judge == true) {
                $empname[] = Employee::where('id',$compshift->emppartid)->value('name');
                $emppartname[] = Employee::where('id',$compshift->emppartid)->value('name');
            }else {
                $partname[] = Parttimer::where('id',$compshift->emppartid)->value('name');
                $emppartname[] = Parttimer::where('id',$compshift->emppartid)->value('name');
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

        return view('shiftEdit',compact('employees','parttimers','empname','partname','emppartname','completeshift','loginid','empjudge','Staffworkdays','StaffTimes','week','workstarttime','workendtime','emppartcount'));
    }


    /* シフト編集上書き処理 変える*/
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

    public function shift_add(Request $request)
    {
        $adminid=Auth::guard('admin')->id();
        $employeeid=Auth::guard('employee')->id();
        $parttimerid=Auth::guard('parttimer')->id();
        $loginid = 0;
        $judge = 0;
        if(isset($adminid)) {
            $storeid = admin::where('id',$adminid)->value('store_id');
         }elseif(isset($employeeid)) {             
            $storeid = Employee::where('id',$employeeid)->value('store_id');
            $loginid = $employeeid;
            $judge = true;
        }elseif(isset($parttimerid)) {
            $storeid = Parttimer::where('id',$parttimerid)->value('store_id');
            $loginid = $parttimerid;
            $judge = false;
        }

        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
        $completeshift = CompleteShift::where('store_id',$storeid)->get();
        $staffcompleteshift = CompleteShift::where('emppartid',$loginid)->where('judge',$judge)->get();
        $privatestaffshift = StaffShift::where('emppartid',$loginid)->where('judge',$judge)->get();

        $empname = [];
        $partname = [];
        $i = 0;
        $data_name = ['year', 'month', 'day', 'comment', 'kind', 'start', 'end'];
        $shift_data_list = [];
        $shift_data = [];
        $day_list = [];


        //31日ループ
        for ($x = 0; $x < 31; $x++) {
            $shift_data = [];
            //データの種類でループ
            for ($i = 0; $i < count($data_name); $i++) {
                // 受け取り判定
                if (isset($_POST[$data_name[$i] . strval($x)])) {
                    // 連想配列作成
                    $shift_data += [$data_name[$i] => $_POST[$data_name[$i] . strval($x)]];
                }
                // dump($data_name[$i].":".$x.":".$test);
            }
            //連想配列を配列に格納(多次元配列にしてる)
            $shift_data_list[$x] = $shift_data;
            $work[$x] = '-'; 
        }

        // ソート処理(月＞日：昇順)
        // $month = array_column($shift_data_list, 'month');
        // $day = array_column($shift_data_list, 'day');
        // array_multisort($month, SORT_ASC, $day, SORT_ASC, $shift_data_list);    

        for ($x = 0; $x < 31; $x++) {
            if (isset($shift_data_list[$x]['day'])) {
                $work[$shift_data_list[$x]['day']] = $shift_data_list[$x]['start'] .'-' .$shift_data_list[$x]['end'];
            }
        }

        // $privatestaffshift = StaffShift::where('emppartid',$loginid)->where('judge',$empjudge)->get();

        // foreach($privatestaffshift as $staffshift) {
        //     for($day= 1; $day <= 31; $day++) {
        //         $hentai="day".$day;
        //         if($staffshift->$hentai != "-1") {
        //             $staffshiftworkday++;
        //         }
        //     }
        // }

        // 送信された月の数だけinsertを行う
            \DB::table('staffshift')->insert([
                'store_id'=>$storeid,
                'emppartid'=>$loginid,
                'judge' => $judge,
                'month'=> 1,
                'day1'=> $work[0],
                'day2' => $work[1],
                'day3' => $work[2],
                'day4' => $work[3],
                'day5' => $work[4],
                'day6' => $work[5],
                'day7' => $work[6],
                'day8' => $work[7],
                'day9' => $work[8],
                'day10' => $work[9],
                'day11' => $work[10],
                'day12' => $work[11],
                'day13' => $work[12],
                'day14' => $work[13],
                'day15' => $work[14],
                'day16' => $work[15],
                'day17' => $work[16],
                'day18' => $work[17],
                'day19' => $work[18],
                'day20' => $work[19],
                'day21' => $work[20],
                'day22' => $work[21],
                'day23' => $work[22],
                'day24' => $work[23],
                'day25' => $work[24],
                'day26' => $work[25],
                'day27' => $work[26],
                'day28' => $work[27],
                'day29' => $work[28],
                'day30' => $work[29],
                'day31' => $work[30],
            ]);
        
        return view('shiftCreate');
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