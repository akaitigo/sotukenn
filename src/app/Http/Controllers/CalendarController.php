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
        $userid;
        $guard;
        $userShift=null;
        $storeid;
        $carbonNow = Carbon::now();
        $thisMonth = $carbonNow->month;
        $firstDay = $carbonNow->firstOfMonth()->day;
        $lastDate = $carbonNow->lastOfMonth()->day;
        if(Auth::guard('admin')->id()!=null){
            $userid = Auth::guard('admin')->id();
            $guard = "admin";
            $storeid = admin::where('id',$userid)->value('store_id');
        }else if(Auth::guard('employee')->id()!=null){
            $userid = Auth::guard('employee')->id();
            $guard = "employee";
            $storeid = Employee::where('id',$userid)->value('store_id');
            $userShift = CompleteShift::where('store_id',$storeid)->where('month',$thisMonth)->where('emppartid',$userid)->where('judge',true)->first();
        }else if(Auth::guard('parttimer')->id()!=null){
            $userid = Auth::guard('parttimer')->id();
            $guard = "parttimer";
            $storeid = Parrttimer::where('id',$userid)->value('store_id');
            $userShift = CompleteShift::where('store_id',$storeid)->where('month',$thisMonth)->where('emppartid',$userid)->where('judge',false)->first();
        }
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
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
            "shift"=>"-",
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
        if($userShift!=null){
            for($i=1;$i<=$lastDate;$i++){
                $str="day".$i;
                
                if($userShift->$str!="×"&&$userShift->$str!="-"){
                    $calendarData[$i]["shift"] = $userShift->$str;
                }
            }
        }
        return view('calendar',compact('calendarData','guard'));
    }
}
