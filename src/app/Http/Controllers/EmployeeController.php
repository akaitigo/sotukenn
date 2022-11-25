<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\Job;
use Illuminate\Database\Console\DumpCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDO;
use Symfony\Component\Console\Command\DumpCompletionCommand;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputOption;

use function PHPUnit\Framework\isNull;

class EmployeeController extends Controller
{

    //パスワードを表示、復元
    public function empPasswordView()
    {
        $employees = Employee::all();
        $parttimers = Parttimer::all();
        foreach ($parttimers as $part) {
            $decrypted = Crypt::decryptString($part->password); //partパスワードの復元
            $part->password = $decrypted;
        }
        foreach ($employees as $emp) {
            $decrypted = Crypt::decryptString($emp->password); //empパスワードの復元
            $emp->password = $decrypted;
        }
        return view('employeesManagementPassView', compact('employees', 'parttimers'));
    }

    //パスワード非表示にする
    public function empPasswordNotView()
    {
        $employees = Employee::all();
        $parttimers = Parttimer::all();
        return view('employeesManagement', compact('employees', 'parttimers'));
    }


    //-->変更対象受け渡し
    public function empChange(Request $request) //変更ボタン押下の際呼び出し
    {
        $partChangeIden = false;
        $empChangeIden = true;
        $getId = $request->input('empChange');
        $employees = Employee::where('id', '=', $getId)->get();
        $allJob = Job::get();
        $jobcheck[0] = 0;
        $jobCount = 1;
        foreach ($employees as $emp) {
            $decrypted = Crypt::decryptString($emp->password); //empパスワードの復元
            $emp->password = $decrypted;
            foreach ($emp->jobs as $job) {
                $jobcheck[] = $job->id;
            }
        }
        return view('employeesManagementChange', compact('employees', 'allJob', 'empChangeIden', 'partChangeIden', 'jobcheck'));
    }
    public function partChange(Request $request) //変更ボタン押下の際呼び出し
    {
        $empChangeIden = false;
        $partChangeIden = true;
        $getId = $request->input('partChange');
        $parttimers = Parttimer::where('id', '=', $getId)->get();
        $allJob = Job::get();
        foreach ($parttimers as $part) {
            $decrypted = Crypt::decryptString($part->password); //empパスワードの復元
            $part->password = $decrypted;
        }
        return view('employeesManagementChange', compact('allJob', 'parttimers', 'partChangeIden', 'empChangeIden'));
    }
    //<- 変更対象受け渡し

    //削除->

    public function empDelete(Request $request)
    {
        $parttimers = Parttimer::all();
        $getId = $request->input('delete');
        $deleteUser = Employee::where('id', '=', $getId)->get();
        $employees = Employee::all();
        foreach ($deleteUser as $del) {
            $del->jobs()->detach(); //外部参照から切り離し
        }
        Employee::where('id', '=', $getId)->delete(); //削除
        $parttimers = Parttimer::all();
        $employees = Employee::all(); //削除後のデータを取得
        return view('employeesManagement', compact('employees', 'parttimers'));
    }

    public function partDelete(Request $request)
    {
        $parttimers = Parttimer::all();
        $getId = $request->input('delete');
        $deleteUser = Parttimer::where('id', '=', $getId)->get();
        $employees = Employee::all();
        foreach ($deleteUser as $del) {
            $del->jobs()->detach();
            $del->statuses()->detach();
        }
        Parttimer::where('id', '=', $getId)->delete();
        $parttimers = Parttimer::all();
        $employees = Employee::all();
        return view('employeesManagement', compact('employees', 'parttimers'));
    }

    //削除->


    //<-上書き更新↓
    public  function empUpdate(Request $request)
    {
        $jobCount = Job::get();
        $jobCountNum = $jobCount->count();
        $getId = $request->input('upDateId');
        $inputName = $request->input('newEmpName');
        $inputEmail = $request->input('newEmpEmail');
        $inputWeight = $request->input('newEmpWeight');
        $inputPassword = $request->input('newEmpPassword');
        $updateUser = Employee::where('id', '=', $getId)->get();
        $alljobCheck = 3; //3の場合すべてのジョブが登録されていない
        $jobCount = 1;

        if (!(is_null($inputName))) {
            $changeConfirmName = $inputName;
        }
        if (!(isNull($inputEmail))) {
            $changeConfirmEmail = $inputEmail;
        }
        foreach ($updateUser as $remp) {
            $remp->name = $changeConfirmName;
            $remp->save();
        }




        foreach ($updateUser as $up) {
            foreach ($up->jobs as $job) {
                for ($i = 1; $i <= $jobCountNum; $i++) {
                    if ($jobCount == $job->id) {
                        $jobcheck[$jobCount] = 0; //0であれば存在している上書き禁止
                        $jobCount = $jobCount + 1;
                        $alljobCheck = 0; //既にデータあり判定
                    } else {
                        $jobcheck[$jobCount] = 1;
                        $jobCount = $jobCount + 1;
                        $alljobCheck = 0;
                    }
                }
            }
            if ($alljobCheck == 3) {
                for ($i = 1; $i <= $jobCountNum; $i++) {
                    $jobcheck[$jobCount] = 1;
                    $jobCount = $jobCount + 1;
                }
            }
        }
        $jobCount = 1;
        for ($i = 1; $i <= $jobCountNum; $i++) {
            $inputPosition[$jobCount] = $request->input($jobCount);
            if (!(is_null($inputPosition[$jobCount]))) { //チェックボックス選択状態の判定選択されている状態である場合
                if ($jobcheck[$jobCount] == 1) {
                    foreach ($updateUser as $up) {
                        $up->jobs()->attach($inputPosition[$jobCount]); //登録
                        $jobcheck[$jobCount] = 0;
                        $jobCount = $jobCount + 1;
                    }
                } else {
                    foreach ($updateUser as $up) {
                        foreach ($up->jobs as $jobs) {
                            $jobCount = $jobCount + 1;
                        }
                    }
                }
            } else {
                foreach ($updateUser as $up) {
                    $up->jobs()->detach($jobCount); //削除
                    $jobcheck[$jobCount] = 1;
                }
            }
        }
        $employees = Employee::all();
        $parttimers = Parttimer::all();

        return view('employeesManagement', compact('employees', 'parttimers'));
    }

    public function partUpdate()
    {
    }

    //<--上書き更新



}
