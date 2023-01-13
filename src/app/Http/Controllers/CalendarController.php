<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompleteShift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use Yasumi\Yasumi;

class CalendarController extends Controller
{
    public function toLogin()
    {
        return redirect(route('parttimer.login'));
    }
    public function toRegister()
    {
        return redirect(route('parttimer.register'));
    }
    public function foovar()
    {
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
        
        $carbonNow = Carbon::now();
        $thisMonth = $carbonNow->month;
        $firstDay = $carbonNow->firstOfMonth()->day;
        $lastDate = $carbonNow->lastOfMonth()->day;
        // echo $lastDate;
        // echo("<br>"); 
        // echo $thisMonth;
        // echo("<br>");
        // echo $firstDay;
        // echo("<br>");
        // echo $carbonNow;
        
        $storeShift = CompleteShift::where('store_id',$storeid)->where('month',$thisMonth)->get();
        $calendarData = [
            [
                'day'=>Carbon::now()->firstOfMonth()->dayOfWeek,
                'month'=>$thisMonth,
                'lastDay'=>$lastDate,
            ]
        ];
        $dateArrayHinagata = [
            "memberCount" => 0,
            "holiday" =>"-",
            "event"=>[""],
        ];
        for($i=1;$i<=$lastDate;$i++){
            array_push($calendarData,$dateArrayHinagata);
        }
        //その日入る人数
        foreach($storeShift as $shift){
            for($i=1;$i<=$lastDate;$i++){
                $str="day".$i;
                
                if($shift->$str!="×"&&$shift->$str!="-"){
                    $calendarData[$i]["memberCount"] = $calendarData[$i]["memberCount"]+1;
                }
            }
        }
        //祝日を入れる
        $holidays = Yasumi::create('Japan', '2023', 'ja_JP');
        $holidaysInBetweenDays = $holidays->between(
            Carbon::now()->firstOfMonth(),
            Carbon::now()->lastOfMonth()
        );
        foreach($holidaysInBetweenDays as $holiday) {
            $calendarData[$holiday->format('j')]['holiday'] = $holiday->getName();
        }
        //イベントを入れる
        return view('calendar',compact('calendarData'));
    }
}
