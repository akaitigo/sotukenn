<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompleteShift;
use App\Models\Employee;
use App\Models\Parttimer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

use PDF;

class OutputController extends Controller
{

    public function outputpage($year,$month){
        return view('output', compact(
            'month',
            'year'
        ));
    }
    public function makefile($year,$month){
        $storeid;
        if(Auth::guard('admin')->check()){
            $storeid=Auth::guard('admin')->user()->store_id;
        }else if(Auth::guard('employee')->check()){
            $storeid=Auth::guard('employee')->user()->store_id;
        }else if(Auth::guard('parttimer')->check()){
            $storeid=Auth::guard('parttimer')->user()->store_id;
        } 
        //ディレクトリ確認
        $storagePath=storage_path();
        //段階的に作ったほうがいい
        if(!file_exists($storagePath . '/app/shift')) {
            mkdir($storagePath . '/app/shift');
        }
        if(!file_exists($storagePath . '/app/shift/' . $storeid)) {
            mkdir($storagePath . '/app/shift/' . $storeid);
        }
        if(!file_exists($storagePath . '/app/shift/' . $storeid.'/'.$year)) {
            mkdir($storagePath . '/app/shift/' . $storeid.'/'.$year);
        }
        if(!file_exists($storagePath . '/app/shift/' . $storeid.'/'.$year.'/csv')) {
            mkdir($storagePath . '/app/shift/' . $storeid.'/'.$year.'/csv');
        }
        if(!file_exists($storagePath . '/app/shift/' . $storeid.'/'.$year.'/pdf')) {
            mkdir($storagePath . '/app/shift/' . $storeid.'/'.$year.'/pdf');
        }
        if(!file_exists($storagePath . '/app/shift/' . $storeid.'/'.$year.'/image')) {
            mkdir($storagePath . '/app/shift/' . $storeid.'/'.$year.'/image');
        }
        $filePath = $storagePath.'/app/shift/'.$storeid.'/'.$year;
        
        $completeshift = CompleteShift::where('store_id', $storeid)->where('month', $month)->get();
        //csv作成
        $stream = fopen('php://temp', 'w');
        $arr = array('名前');
        $lastDate=new Carbon($year.'-01-01');
        $day=$lastDate->dayOfWeek;
        $daycount=$day;
        $lastDate=$lastDate->daysInMonth;
        $youbi=['日','月','火','水','木','金','土'];
        for($i=1;$i<=$lastDate;$i++){
            $str=$i.'('.$youbi[$daycount].')';
            array_push($arr,$str);
            $daycount++;
            if($daycount==7){
                $daycount=0;
            }
        }
        $daycount = $day;
        fputcsv($stream, $arr);
        $allshift = [];
        foreach($completeshift as $shift){
            $name;
            if($shift['judge']){
                $name=Employee::where('store_id',$storeid)->where('id',$shift['emppartid'])->value('name');
            }else{
                $name=Parttimer::where('store_id',$storeid)->where('id',$shift['emppartid'])->value('name');
            }
            $shiftArray=array('名前'=>$name);
            for($i=1;$i<=$lastDate;$i++){
                $str=$i.'('.$youbi[$daycount].')';
                $shiftArray = array_merge($shiftArray,array($str=>$shift['day'.$i]));
                $daycount++;
                if($daycount==7){
                    $daycount=0;
                }
            }
            $daycount=$day;
            fputcsv($stream, $shiftArray); 
            array_push($allshift,$shiftArray);
        }
        rewind($stream);                      
        $csv = stream_get_contents($stream);
        $path = "shift/".$storeid."/".$year."/csv/".$month.".csv";
        Storage::put($path, $csv);
        fclose($stream);
        //pdf作成
        // dump($arr);
        // dump($allshift);
        // return;
        $path = "shift/".$storeid."/".$year."/pdf/".$month.".pdf";
        $pdf = PDF::loadView('pdf', compact('arr','allshift','month','year'))
                        ->setPaper('a4','landscape');
        Storage::put($path,$pdf->output()) ;
        //image作成          
        $imagepath = "shift/".$storeid."/".$year."/image/".$month.".jpeg";
        $command = "pdftoppm -jpeg -f 1 -l 1 ".storage_path('app/'.$path)." > ".storage_path('app/'.$imagepath);
        shell_exec($command);
    }
    public function downloadcsv($year,$month){
        $storeid;
        if(Auth::guard('admin')->check()){
            $storeid=Auth::guard('admin')->user()->store_id;
        }else if(Auth::guard('employee')->check()){
            $storeid=Auth::guard('employee')->user()->store_id;
        }else if(Auth::guard('parttimer')->check()){
            $storeid=Auth::guard('parttimer')->user()->store_id;
        } 
        if(!file_exists(storage_path().'/app/shift/'.$storeid.'/csv/'.$month.'.csv')){
            $this->makefile($year,$month);
        }
        $filePath = '/shift/'.$storeid."/".$year.'/csv/'.$month.'.csv';
        return Storage::download($filePath);
    }
    public function downloadpdf($year,$month){
        $storeid;
        if(Auth::guard('admin')->check()){
            $storeid=Auth::guard('admin')->user()->store_id;
        }else if(Auth::guard('employee')->check()){
            $storeid=Auth::guard('employee')->user()->store_id;
        }else if(Auth::guard('parttimer')->check()){
            $storeid=Auth::guard('parttimer')->user()->store_id;
        } 
        if(!file_exists(storage_path().'/app/shift/'.$storeid.'/pdf/'.$month.'.pdf')){
            $this->makefile($year,$month);
        }
        $filePath = '/shift/'.$storeid."/".$year.'/pdf/'.$month.'.pdf';
        return Storage::download($filePath);
    }   
    public function downloadimage($year,$month){
        $storeid;
        if(Auth::guard('admin')->check()){
            $storeid=Auth::guard('admin')->user()->store_id;
        }else if(Auth::guard('employee')->check()){
            $storeid=Auth::guard('employee')->user()->store_id;
        }else if(Auth::guard('parttimer')->check()){
            $storeid=Auth::guard('parttimer')->user()->store_id;
        } 
        if(!file_exists(storage_path().'/app/shift/'.$storeid.'/image/'.$month.'.jpeg')){
            $this->makefile($year,$month);
        }
        $filePath = '/shift/'.$storeid."/".$year.'/image/'.$month.'.jpeg';
        return Storage::download($filePath);
    }
    public function createdcheck($year,$month){

    }
}
