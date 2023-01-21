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
use App\Models\Comment;
use App\Models\Shiftdivider;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yasumi\Yasumi;

class ShiftController extends Controller
{

    private $formItems = ["workstarttime", "workendtime", "submissionlimit", "vote"];


    /* 提出シフト管理 */
    public function management()
    {
        $adminid = Auth::guard('admin')->id();
        $storeid = admin::where('id', $adminid)->value('store_id');
        $employees = Employee::where('store_id', $storeid)->get();
        $parttimers = Parttimer::where('store_id', $storeid)->get();

        $allempid = [];
        $allempname = [];
        $submitcompempid = [];
        $submitcompempname = [];
        $allpartid = [];
        $allpartname = [];
        $submitcomppartid = [];
        $submitcomppartname = [];


        foreach ($employees as $emp) {
            $allempid[] = $emp->id;
            $allempname[] = $emp->name;
            foreach ($emp->Statuses as $status) {
                if ($status->id == 4) {
                    $submitcompempid[] = $emp->id;
                    $submitcompempname[] = $emp->name;
                }
            }
        }
        foreach ($parttimers as $part) {
            $allpartname[] = $part->name;
            foreach ($part->Statuses as $status) {
                if ($status->id == 4) {
                    $submitcomppartid[] = $part->id;
                    $submitcomppartname[] = $part->name;
                }
            }
        }

        $notsubmitempname = array_diff($allempname, $submitcompempname);
        $notsubmitpartname = array_diff($allpartname, $submitcomppartname);

        return view('submittedShift', compact('employees', 'parttimers', 'submitcompempid', 'submitcomppartid', 'submitcompempname', 'notsubmitempname', 'submitcomppartname', 'notsubmitpartname'));
    }

    /* シフト設定 */
    public function firstsetting(Request $request)
    {

        $data = $request->only($this->formItems);
        $vote = $request->input('vote');
        if (is_null($vote)) {
            $data['vote'] = 0;
        } else {
            $data['vote'] = 1;
        }
        /*認証コード*/
        $adminid = Auth::guard('admin')->id();
        $storeid = admin::where('id', $adminid)->value('store_id');
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


    /* シフト閲覧 変えた*/
    public function view()
    {
        $userId;
        $storeid;
        $empjudge = 0;
        if (Auth::guard('admin')->check()) {
            $userId = Auth::guard('admin')->id();
            $storeid = admin::where('id', $userId)->value('store_id');
            $userId = 0;
        } else if (Auth::guard('employee')->check()) {
            $userId = Auth::guard('employee')->id();
            $storeid = Employee::where('id', $userId)->value('store_id');
            $empjudge = true;
        } else if (Auth::guard('parttimer')->check()) {
            $userId = Auth::guard('parttimer')->id();
            $storeid = Parttimer::where('id', $userId)->value('store_id');
            $empjudge = false;
        }
        $employees = Employee::where('store_id', $storeid)->get();
        $parttimers = Parttimer::where('store_id', $storeid)->get();

        $carbonNow = Carbon::now();
        $carbonNext = Carbon::now()->addMonth(1);
        if ($carbonNext->month == 13) {
            $carbonNext = Carbon::now()->Month(1);
        }
        $thisMonth = $carbonNow->month;
        $thisMonthNext = $carbonNext->month;
        $firstDay = $carbonNow->firstOfMonth()->day;
        $firstDayNext = $carbonNext->firstOfMonth()->day;
        $lastDate = $carbonNow->lastOfMonth()->day;
        $lastDateNext = $carbonNext->lastOfMonth()->day;

        $completeshift = CompleteShift::where('store_id', $storeid)->where('month', $thisMonth)->get();
        $staffcompleteshift = CompleteShift::where('emppartid', $userId)->where('judge', $empjudge)->where('month', $thisMonth)->get();
        $privatestaffshift = StaffShift::where('emppartid', $userId)->where('judge', $empjudge)->where('month', $thisMonth)->get();

        $completeshiftNext = CompleteShift::where('store_id', $storeid)->where('month', $thisMonthNext)->get();
        $staffcompleteshiftNext = CompleteShift::where('emppartid', $userId)->where('judge', $empjudge)->where('month', $thisMonthNext)->get();
        $privatestaffshiftNext = StaffShift::where('emppartid', $userId)->where('judge', $empjudge)->where('month', $thisMonthNext)->get();


        $calendarData = [
            [
                'day' => $carbonNow->firstOfMonth()->dayOfWeek,
                'month' => $thisMonth,
                'lastDay' => $lastDate,
            ]
        ];

        $calendarDataNext = [
            [
                'day' => $carbonNext->firstOfMonth()->dayOfWeek,
                'month' => $thisMonthNext,
                'lastDay' => $lastDateNext,
            ]
        ];

        //祝日を入れる
        $holidays = Yasumi::create('Japan', '2023', 'ja_JP');
        $holidaysInBetweenDays = $holidays->between(
            Carbon::now()->firstOfMonth(),
            Carbon::now()->lastOfMonth()
        );
        $holidaysInBetweenDaysNext = $holidays->between(
            Carbon::now()->addMonth(1)->firstOfMonth(),
            Carbon::now()->addMonth(1)->lastOfMonth()
        );
        $array = ['-'];
        $arrayNext = ['-'];
        for ($i = 1; $i <= $lastDate; $i++) {
            array_push($array, '-');
        }
        for ($i = 1; $i <= $lastDateNext; $i++) {
            array_push($arrayNext, '-');
        }
        foreach ($holidaysInBetweenDays as $holiday) {
            $array[$holiday->format('j')] = $holiday->getName();
        }
        foreach ($holidaysInBetweenDaysNext as $holidayNext) {
            $arrayNext[$holidayNext->format('j')] = $holidayNext->getName();
        }

        // 今月のシフト閲覧
        // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $empname = [];
        $partname = [];
        $StaffTimes = [];
        $Staffworkdays = [];
        $i = 0;

        //社員を配列格納　労働時間と日数計算
        foreach ($completeshift as $compshift) {
            if ($compshift->judge == true) {
                $empname[] = Employee::where('id', $compshift->emppartid)->value('name');
            } else {
                $partname[] = Parttimer::where('id', $compshift->emppartid)->value('name');
            }

            (float)$StaffTime = 0;
            (float)$StaffsumTime = 0;
            $Staffworkday = 0;

            for ($j = 1; $j <= $lastDate; $j++) {
                $hentai = "day" . $j;

                if ($compshift->$hentai != "×" && $compshift->$hentai != "-") {
                    (int)$num1 = strpos($compshift->$hentai, "-"); //出勤、退勤抜き出しに使用
                    (float)$in1 =  (float) substr($compshift->$hentai, 0, $num1); //提出シフトの出勤時間抜き出し
                    (float)$out1 =  (float) substr($compshift->$hentai, $num1 + 1); //提出シフトの退勤時間抜き出し
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

        foreach ($staffcompleteshift as $staffcompshift) {
            for ($j = 1; $j <= $lastDate; $j++) {
                $hentai = "day" . $j;
                if ($staffcompshift->$hentai != "×" && $staffcompshift->$hentai != "-") {
                    $staffshiftcompleteworkday++;
                }
            }
        }

        foreach ($privatestaffshift as $staffshift) {
            for ($j = 1; $j <= $lastDate; $j++) {
                $hentai = "day" . $j;
                if ($staffshift->$hentai != "-1") {
                    $staffshiftworkday++;
                }
            }
        }

        if ($userId != 0) {                               //これないとバグる
            if ($staffshiftcompleteworkday == 0 || $staffshiftworkday == 0) {
                $staffshiftcover = 0;
            } else {
                (int)$staffshiftcover = ($staffshiftcompleteworkday / $staffshiftworkday) * 100;
                $staffshiftcover = round($staffshiftcover, 0);
                if ($staffshiftcover >= 100) {
                    $staffshiftcover = 100;
                }
            }
        }
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        // 来月のシフト閲覧
        // ↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $empnameNext = [];
        $partnameNext = [];
        $StaffTimesNext = [];
        $StaffworkdaysNext = [];
        $i = 0;
        $nextcomshiftjudge = 0;

        //社員を配列格納　労働時間と日数計算
        foreach ($completeshiftNext as $compshiftNext) {
            $nextcomshiftjudge = 1;
            if ($compshiftNext->judge == true) {
                $empnameNext[] = Employee::where('id', $compshiftNext->emppartid)->value('name');
            } else {
                $partnameNext[] = Parttimer::where('id', $compshiftNext->emppartid)->value('name');
            }

            (float)$StaffTimeNext = 0;
            (float)$StaffsumTimeNext = 0;
            $StaffworkdayNext = 0;

            for ($j = 1; $j <= $lastDateNext; $j++) {
                $hentai = "day" . $j;

                if ($compshiftNext->$hentai != "×" && $compshiftNext->$hentai != "-") {
                    (int)$num1 = strpos($compshiftNext->$hentai, "-"); //出勤、退勤抜き出しに使用
                    (float)$in1 =  (float) substr($compshiftNext->$hentai, 0, $num1); //提出シフトの出勤時間抜き出し
                    (float)$out1 =  (float) substr($compshiftNext->$hentai, $num1 + 1); //提出シフトの退勤時間抜き出し
                    $StaffTimeNext = $out1 - $in1;
                    $StaffsumTimeNext = $StaffsumTimeNext + $StaffTimeNext;
                    $StaffworkdayNext++;
                }
            }
            $StaffTimesNext[$i] = $StaffsumTimeNext;
            $StaffworkdaysNext[$i] = $StaffworkdayNext;
            $i++;
        }

        $staffshiftcompleteworkdayNext = 0;
        $staffshiftworkdayNext = 0;
        (int)$staffshiftcoverNext = 0;

        foreach ($staffcompleteshiftNext as $staffcompshiftNext) {
            for ($j = 1; $j <= $lastDateNext; $j++) {
                $hentai = "day" . $j;
                if ($staffcompshiftNext->$hentai != "×" && $staffcompshiftNext->$hentai != "-") {
                    $staffshiftcompleteworkdayNext++;
                }
            }
        }

        foreach ($privatestaffshiftNext as $staffshiftNext) {
            for ($j = 1; $j <= $lastDateNext; $j++) {
                $hentai = "day" . $j;
                if ($staffshiftNext->$hentai != "-1") {
                    $staffshiftworkdayNext++;
                }
            }
        }

        if ($userId != 0) {                               //これないとバグる
            if ($staffshiftcompleteworkdayNext == 0 || $staffshiftworkdayNext == 0) {
                $staffshiftcoverNext = 0;
            } else {
                (int)$staffshiftcoverNext = ($staffshiftcompleteworkdayNext / $staffshiftworkdayNext) * 100;
                $staffshiftcoverNext = round($staffshiftcoverNext, 0);
                if ($staffshiftcoverNext >= 100) {
                    $staffshiftcoverNext = 100;
                }
            }
        }
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        $shift_divicount = 0;

        $shiftdivider = Shiftdivider::where('store_id', $storeid)->get();

        foreach($shiftdivider as $shift_divi) {
            for($time = 1;$time <= 30; $time++) {
                $shifttime = 'time'.$time;
                if($shift_divi->$shifttime != null) {
                    $shift_divicount++;
                }
            }
        }

        $week = ['日', '月', '火', '水', '木', '金', '土'];

        return view('new_shiftView', compact(
            'empname',
            'partname',
            'completeshift',
            'userId',
            'empjudge',
            'Staffworkdays',
            'StaffTimes',
            'staffshiftcover',
            'week',
            'calendarData',
            'array',
            'empnameNext',
            'partnameNext',
            'completeshiftNext',
            'StaffworkdaysNext',
            'StaffTimesNext',
            'staffshiftcoverNext',
            'calendarDataNext',
            'arrayNext',
            'nextcomshiftjudge',
            'shiftdivider',
            'shift_divicount'
        ));
    }



    /* シフト編集 変える*/
    public function edit()
    {
        $adminid = Auth::guard('admin')->id();
        $employeeid = Auth::guard('employee')->id();
        $parttimerid = Auth::guard('parttimer')->id();
        $loginid = 0;
        $empjudge = 0;
        if (isset($adminid)) {
            $storeid = admin::where('id', $adminid)->value('store_id');
        } elseif (isset($employeeid)) {
            $storeid = Employee::where('id', $employeeid)->value('store_id');
            $loginid = $employeeid;
            $empjudge = true;
        } elseif (isset($parttimerid)) {
            $storeid = Parttimer::where('id', $parttimerid)->value('store_id');
            $loginid = $parttimerid;
            $empjudge = false;
        }

        $employees = Employee::where('store_id', $storeid)->get();
        $parttimers = Parttimer::where('store_id', $storeid)->get();
        $workstarttime = Store::where('id', $storeid)->value('workstarttime');
        $workendtime = Store::where('id', $storeid)->value('workendtime');


        $carbonNow = Carbon::now();
        $thisMonth = $carbonNow->month;
        $firstDay = $carbonNow->firstOfMonth()->day;
        $lastDate = $carbonNow->lastOfMonth()->day;
        $calendarData = [
            [
                'day' => Carbon::now()->firstOfMonth()->dayOfWeek,
                'month' => $thisMonth,
                'lastDay' => $lastDate,
            ]
        ];


        //祝日を入れる
        $holidays = Yasumi::create('Japan', '2023', 'ja_JP');
        $holidaysInBetweenDays = $holidays->between(
            $carbonNow->firstOfMonth(),
            $carbonNow->lastOfMonth()
        );
        $array = ['-'];
        $arrayNext = ['-'];
        for ($i = 1; $i <= $lastDate; $i++) {
            array_push($array, '-');
        }
        foreach ($holidaysInBetweenDays as $holiday) {
            $array[$holiday->format('j')] = $holiday->getName();
        }

        $completeshift = CompleteShift::where('store_id', $storeid)->where('month', $thisMonth)->get();

        $empname = [];
        $partname = [];
        $emppartname = [];
        $i = 0;

        foreach ($completeshift as $compshift) {
            if ($compshift->judge == true) {
                $empname[] = Employee::where('id', $compshift->emppartid)->value('name');
                $emppartname[] = Employee::where('id', $compshift->emppartid)->value('name');
            } else {
                $partname[] = Parttimer::where('id', $compshift->emppartid)->value('name');
                $emppartname[] = Parttimer::where('id', $compshift->emppartid)->value('name');
            }

            (float)$StaffTime = 0;
            (float)$StaffsumTime = 0;
            $Staffworkday = 0;

            for ($day = 1; $day <= $calendarData[0]['lastDay']; $day++) {
                $hentai = "day" . $day;

                if ($compshift->$hentai != "×" && $compshift->$hentai != "-") {
                    (int)$num1 = strpos($compshift->$hentai, "-"); //出勤、退勤抜き出しに使用
                    (float)$in1 =  (float) substr($compshift->$hentai, 0, $num1); //提出シフトの出勤時間抜き出し
                    (float)$out1 =  (float) substr($compshift->$hentai, $num1 + 1); //提出シフトの退勤時間抜き出し
                    $StaffTime = $out1 - $in1;
                    $StaffsumTime = $StaffsumTime + $StaffTime;
                    $Staffworkday++;
                }
            }

            $StaffTimes[$i] = $StaffsumTime;
            $Staffworkdays[$i] = $Staffworkday;
            $i++;
        }

        $emppartcount = $i + 1;
        $week = ['日', '月', '火', '水', '木', '金', '土'];

        return view('shiftEdit', compact('array', 'employees', 'parttimers', 'empname', 'partname', 'emppartname', 'completeshift', 'loginid', 'empjudge', 'Staffworkdays', 'StaffTimes', 'week', 'workstarttime', 'workendtime', 'emppartcount', 'calendarData'));
    }


    /* シフト編集上書き処理 変える*/
    public function update(Request $request)
    {

        $adminid = Auth::guard('admin')->id();
        $storeid = admin::where('id', $adminid)->value('store_id');
        $completeshift = CompleteShift::where('store_id', $storeid)->get();
        $emppartcount = 0;
        foreach ($completeshift as $compshift) {
            $emppartcount++;
        }

        foreach ($completeshift as $compshift) {
            for ($day = 1; $day <= 31; $day++) {
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

        $adminid = Auth::guard('admin')->id();
        $employeeid = Auth::guard('employee')->id();
        $parttimerid = Auth::guard('parttimer')->id();
        $loginid = 0;
        $empjudge = 0;
        if (isset($adminid)) {
            $storeid = admin::where('id', $adminid)->value('store_id');
        } elseif (isset($employeeid)) {
            $storeid = Employee::where('id', $employeeid)->value('store_id');
            $loginid = $employeeid;
            $empjudge = true;
        } elseif (isset($parttimerid)) {
            $storeid = Parttimer::where('id', $parttimerid)->value('store_id');
            $loginid = $parttimerid;
            $empjudge = false;
        }

        $employees = Employee::where('store_id', $storeid)->get();
        $parttimers = Parttimer::where('store_id', $storeid)->get();
        $completeshift = CompleteShift::where('store_id', $storeid)->get();
        $staffcompleteshift = CompleteShift::where('emppartid', $loginid)->where('judge', $empjudge)->get();
        $privatestaffshift = StaffShift::where('emppartid', $loginid)->where('judge', $empjudge)->get();

        $empname = [];
        $partname = [];
        $i = 0;

        //社員を配列格納　労働時間と日数計算
        foreach ($completeshift as $compshift) {
            if ($compshift->judge == true) {
                $empname[] = Employee::where('id', $compshift->emppartid)->value('name');
            } else {
                $partname[] = Parttimer::where('id', $compshift->emppartid)->value('name');
            }

            (float)$StaffTime = 0;
            (float)$StaffsumTime = 0;
            $Staffworkday = 0;

            for ($day = 1; $day <= 31; $day++) {
                $hentai = "day" . $day;

                if ($compshift->$hentai != "×" && $compshift->$hentai != "-") {
                    (int)$num1 = strpos($compshift->$hentai, "-"); //出勤、退勤抜き出しに使用
                    (float)$in1 =  (float) substr($compshift->$hentai, 0, $num1); //提出シフトの出勤時間抜き出し
                    (float)$out1 =  (float) substr($compshift->$hentai, $num1 + 1); //提出シフトの退勤時間抜き出し
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

        foreach ($staffcompleteshift as $staffcompshift) {
            for ($day = 1; $day <= 31; $day++) {
                $hentai = "day" . $day;
                if ($staffcompshift->$hentai != "×" && $staffcompshift->$hentai != "-") {
                    $staffshiftcompleteworkday++;
                }
            }
        }

        foreach ($privatestaffshift as $staffshift) {
            for ($day = 1; $day <= 31; $day++) {
                $hentai = "day" . $day;
                if ($staffshift->$hentai != "-1") {
                    $staffshiftworkday++;
                }
            }
        }

        if ($loginid != 0) {                               //これないとバグる
            if ($staffshiftcompleteworkday == 0 || $staffshiftworkday == 0) {
                $staffshiftcover = 0;
            } else {
                (int)$staffshiftcover = ($staffshiftcompleteworkday / $staffshiftworkday) * 100;
                $staffshiftcover = round($staffshiftcover, 0);
                if ($staffshiftcover >= 100) {
                    $staffshiftcover = 100;
                }
            }
        }

        $week = ['日', '月', '火', '水', '木', '金', '土'];

        return redirect()->route('new_shiftView')->with(compact('employees', 'parttimers', 'empname', 'partname', 'completeshift', 'loginid', 'empjudge', 'Staffworkdays', 'StaffTimes', 'staffshiftcover', 'week'));
    }

    public function shift_add(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $parttimer = Auth::guard('parttimer')->user();

        $data = new Carbon('+1 month');
        // $month = $data->month;
        $month = $_POST['month0'];

        $empname = [];
        $partname = [];
        $i = 0;
        $data_name = ['year', 'month', 'day', 'comment', 'kind', 'start', 'end'];
        $shift_data_list = [];
        $shift_data = [];
        $day_list = [];

        $comment_data_name = ['comment_year', 'comment_month', 'comment_day', 'comment_comment', 'comment_kind', 'comment_start', 'comment_end'];
        $comment_data_list = [];
        $comment_data = [];

        //31日ループ
        for ($x = 0; $x < 31; $x++) {
            $shift_data = [];
            //データの種類でループ
            for ($i = 0; $i < count($data_name); $i++) {
                // 受け取り判定
                if (isset($_POST[$data_name[$i] . strval($x)]) && $_POST['month' . strval($x)] == $month) {
                    // 連想配列作成
                    $shift_data += [$data_name[$i] => $_POST[$data_name[$i] . strval($x)]];
                }
                // dump($data_name[$i].":".$x.":".$test);
            }
            //連想配列を配列に格納(多次元配列にしてる)
            $shift_data_list[$x] = $shift_data;
            $work[$x] = -1;
        }
        dump($shift_data_list[0]['day']);
        if ($shift_data_list[0]['day'] != "") {
            for ($x = 0; $x < 31; $x++) {
                if (isset($shift_data_list[$x]['day']) && $_POST['month' . strval($x)] == $month) {
                    $work[$shift_data_list[$x]['day'] - 1] = $shift_data_list[$x]['start'] . '-' . $shift_data_list[$x]['end'];
                }
            }
        }

        dump($work);

        for ($x = 0; $x < 31; $x++) {
            $comment_data = [];
            //データの種類でループ
            for ($i = 0; $i < count($comment_data_name); $i++) {
                // 受け取り判定
                if (isset($_POST[$comment_data_name[$i] . strval($x)]) && $_POST['comment_month' . strval($x)] == $month) {
                    // 連想配列作成
                    $comment_data += [$comment_data_name[$i] => $_POST[$comment_data_name[$i] . strval($x)]];
                }
                // dump($data_name[$i].":".$x.":".$test);
            }
            //連想配列を配列に格納(多次元配列にしてる)
            $comment_data_list[$x] = $comment_data;
            $comment_work[$x] = null;
        }
        dump($comment_data_list);
        if ($comment_data_list[0]['comment_day'] != "") {
            for ($x = 0; $x < 31; $x++) {
                if (isset($comment_data_list[$x]['comment_day'])) {
                    $comment_work[$comment_data_list[$x]['comment_day'] - 1] = $comment_data_list[$x]['comment_comment'];
                }
            }

            dump($comment_work);
        }
        //ここまで正常
        if (!(is_null($employee->email))) { //ログイン中のユーザ情報の取得
            $empuserEmail = $employee->email;
            $employee = Employee::where('email', $empuserEmail)->get();
            foreach ($employee as $emp) {
                $shift = StaffShift::where('emppartid', $emp->id)->where('judge', true)->where('month', $month)->get();
                $empShiftNullCheck = false;
                foreach ($shift as $shi) {
                    $empShiftNullCheck = true;
                }
                if (!($empShiftNullCheck)) {
                    \DB::table('staffshift')->insert([
                        'emppartid' => $emp->id,
                        'store_id' => $emp->store_id,
                        'judge' => true,
                        'month' => $month,
                    ]);
                }
            }


            $shift = StaffShift::where('emppartid', $emp->id)->where('judge', true)->where('month', $month)->get();
            foreach ($shift as $shi) {
                for ($i = 0; $i < 31; $i++) {
                    $dayTemp = 'day' . $i + 1;
                    if ($i == 0) {
                        if (!($shi->$i === '-')) {
                            $dayTemp = 'day' . $i + 1;
                            $shi->$dayTemp = $work[$i];
                            $shi->timestamps = false;
                            $shi->save();
                        }
                    } else {
                        if (!($shi->$i === '-')) {
                            $shi->$dayTemp = $work[$i];
                            $shi->timestamps = false;
                            $shi->save();
                        }
                    }
                }
            }

            foreach ($employee as $emp) {
                $shift = StaffShift::where('emppartid', $emp->id)->where('judge', true)->where('month', $month)->get();
                $empShiftNullCheck = false;
                foreach ($shift as $shi) {
                    $empShiftNullCheck = true;
                }
                if (!($empShiftNullCheck)) {
                    \DB::table('staffshift')->insert([
                        'emppartid' => $emp->id,
                        'store_id' => $emp->store_id,
                        'judge' => true,
                        'month' => $month,
                    ]);
                }
            }


            $Comment = Comment::where('emppartid', $emp->id)->where('judge', true)->where('month', $month)->get();
            foreach ($Comment as $cmt) {
                for ($i = 0; $i < 31; $i++) {
                    $commentTemp = 'comment' . $i + 1;
                    if ($i == 0) {
                        if (!($cmt->$i === '-')) {
                            $commentTemp = 'comment' . $i + 1;
                            $cmt->$commentTemp = $comment_work[$i];
                            $cmt->timestamps = false;
                            $cmt->save();
                        }
                    } else {
                        if (!($cmt->$i === '-')) {
                            $cmt->$commentTemp = $comment_work[$i];
                            $cmt->timestamps = false;
                            $cmt->save();
                        }
                    }
                }
            }
        } else if (!(is_null($parttimer->email))) {

            $parttimerEmail = $parttimer->email;
            $employee = Parttimer::where('email', $parttimerEmail)->get();
        }
    }

    public function shift_show()
    {
        //月の最大日数の取得
        $data = new Carbon();
        $last_data = $data->daysInMonth;

        $next_data = new Carbon('+1 month');
        $next_month = $next_data->month;
        $next_year = $next_data->year;
        $next_last_data = $next_data->daysInMonth;

        $adminid = Auth::guard('admin')->id();
        $employeeid = Auth::guard('employee')->id();
        $parttimerid = Auth::guard('parttimer')->id();
        $now_month = $data->month;
        $now_year = $data->year;
        $loginid = 0;
        $judge = 0;

        if (isset($adminid)) {
            $storeid = admin::where('id', $adminid)->value('store_id');
        } elseif (isset($employeeid)) {
            $storeid = Employee::where('id', $employeeid)->value('store_id');
            $loginid = $employeeid;
            $judge = true;
        } elseif (isset($parttimerid)) {
            $storeid = Parttimer::where('id', $parttimerid)->value('store_id');
            $loginid = $parttimerid;
            $judge = false;
        }
        //シフト表の情報全て
        $comp_judge = 0;
        $comp_judge_next = 0;
        $now_comp_shift = CompleteShift::where('emppartid', $loginid)->where('judge', $judge)->where('month', $now_month)->get();
        $next_comp_shift = CompleteShift::where('emppartid', $loginid)->where('judge', $judge)->where('month', $next_month)->get();
        foreach($now_comp_shift as $nexc){
            $comp_judge = 1;
        }
        foreach($next_comp_shift as $nexc){
            $comp_judge_next = 1;
        }

        if ($comp_judge == 1) {
            $privatestaffshift = CompleteShift::where('emppartid', $loginid)->where('judge', $judge)->where('month', $now_month)->get();
        }else{
            $privatestaffshift = StaffShift::where('emppartid', $loginid)->where('judge', $judge)->where('month', $now_month)->get();
        }
        if($comp_judge_next == 1){
            $privatestaffshift_next = CompleteShift::where('emppartid', $loginid)->where('judge', $judge)->where('month', $next_month)->get();
        }else{
            $privatestaffshift_next = StaffShift::where('emppartid', $loginid)->where('judge', $judge)->where('month', $next_month)->get();
        }

        $privatecomment = Comment::where('emppartid', $loginid)->where('judge', $judge)->where('month', $now_month)->get();
        $privatecomment_next = Comment::where('emppartid', $loginid)->where('judge', $judge)->where('month', $next_month)->get();

        // コメント情報のすべて まだテーブルできてない
        // $privatestaffcomment = StaffComment::where('emppartid',$loginid)->where('judge',$judge)->get();

        return view('emp_shift_add', compact('privatestaffshift', 'last_data', 'now_month', 'now_year', 'privatecomment', 'privatestaffshift_next', 'privatecomment_next', 'next_last_data', 'next_month', 'next_year'));
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
