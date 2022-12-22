<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    //パスワードを表示、復元
    public function empPasswordView()
    {
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $parttimers = Parttimer::where('store_id',$storeid)->get();

        return view('employeesManagementPassView', compact('employees', 'parttimers'));
    }

    //パスワード非表示にする
    public function empPasswordNotView()
    {
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $parttimers = Parttimer::where('store_id',$storeid)->get();

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
            // $decrypted = Crypt::decryptString($emp->password); //empパスワードの復元
            // $emp->password = $decrypted;
            foreach ($emp->jobs as $job) {
                $jobcheck[] = $job->id;
            }
        }
        return view('employeesManagementChange', compact('employees', 'allJob', 'empChangeIden', 'partChangeIden', 'jobcheck'));
    }
    public function partChange(Request $request) //変更ボタン押下の際呼び出し
    {
        $partChangeIden = true;
        $empChangeIden = false;
        $getId = $request->input('partChange');
        $parttimers = Parttimer::where('id', '=', $getId)->get();
        $allJob = Job::get();

        $jobcheck[0] = 0;
        $jobCount = 1;
        foreach ($parttimers as $part) {
            // $decrypted = Crypt::decryptString($emp->password); //empパスワードの復元
            // $emp->password = $decrypted;
            foreach ($part->jobs as $job) {
                $jobcheck[] = $job->id;
            }
        }
        return view('employeesManagementChange', compact('allJob', 'empChangeIden', 'partChangeIden', 'jobcheck', 'parttimers'));
    }
    //<- 変更対象受け渡し

    //削除->

    public function empDelete(Request $request)
    {
        $parttimers = Parttimer::all();
        $getId = $_POST['delete'];
        $deleteUser = Employee::where('id', '=', $getId)->get();
        $employees = Employee::all();
        foreach ($deleteUser as $del) {
            $del->jobs()->detach(); //外部参照から切り離し
            $del->statuses()->detach();
        }
        Employee::where('id', '=', $getId)->delete(); //削除
        
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
        return view('employeesManagementPassView', compact('employees', 'parttimers'));
    }

    public function partDelete(Request $request)
    {
        $parttimers = Parttimer::all();
        //$getId = $request->input('delete');
        $getId = $_POST['delete'];
        $deleteUser = Parttimer::where('id', '=', $getId)->get();
        $employees = Employee::all();
        foreach ($deleteUser as $del) {
            $del->jobs()->detach();
            $del->statuses()->detach();
        }
        Parttimer::where('id', '=', $getId)->delete();
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();
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
        $inputAge = $request->input('newEmpAge');
        $updateUser = Employee::where('id', '=', $getId)->get();
        $alljobCheck = 3; //3の場合すべてのジョブが登録されていない
        $jobCount = 1;
        foreach ($updateUser as $remp) {
            if (!(is_null($inputName))) {
                $changeConfirmName = $inputName;
                $remp->name = $changeConfirmName;
            }
            if (!(is_null($inputEmail))) {
                $changeConfirmEmail = $inputEmail;
                $remp->email = $changeConfirmEmail;
            }
            if (!(is_null($inputWeight))) {
                $changeConfirmWeight = $inputWeight;
                $remp->weight = $changeConfirmWeight;
            }
            if (!(is_null($inputPassword))) {
                $changeConfirmPassword = $inputPassword;
                $remp->password = Hash::make($changeConfirmPassword);
            }
            if (!(is_null($inputAge))) {
                $changeConfirmAge = $inputAge;
                $remp->age = $changeConfirmAge;
            }
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

                    $up->jobs()->detach($i); //削除
                    $jobcheck[$jobCount] = 1;
                    $jobCount = $jobCount + 1;
                }
            }
        }
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();

        return view('employeesManagementPassView', compact('employees', 'parttimers'));
    }

    public function partUpdate(Request $request)
    {
        $jobCount = Job::get();
        $jobCountNum = $jobCount->count();
        $getId = $request->input('upDateId');
        $inputName = $request->input('newPartName');
        $inputEmail = $request->input('newPartEmail');
        $inputWeight = $request->input('newPartWeight');
        $inputPassword = $request->input('newPartPass');
        $inputAge = $request->input('newPartAge');
        $updateUser = Parttimer::where('id', '=', $getId)->get();
        $alljobCheck = 3; //3の場合すべてのジョブが登録されていない
        $jobCount = 1;

        foreach ($updateUser as $remp) {
            if (!(is_null($inputName))) {
                $changeConfirmName = $inputName;
                $remp->name = $changeConfirmName;
            }
            if (!(is_null($inputEmail))) {
                $changeConfirmEmail = $inputEmail;
                $remp->email = $changeConfirmEmail;
            }
            if (!(is_null($inputWeight))) {
                $changeConfirmWeight = $inputWeight;
                $remp->weight = $changeConfirmWeight;
            }
            if (!(is_null($inputPassword))) {
                $changeConfirmPassword = $inputPassword;
                $remp->password = Hash::make($changeConfirmPassword);
            }
            if (!(is_null($inputAge))) {
                $changeConfirmAge = $inputAge;
                $remp->age = $changeConfirmAge;
            }

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

                    $up->jobs()->detach($i); //削除
                    $jobcheck[$jobCount] = 1;
                    $jobCount = $jobCount + 1;
                }
            }
        }
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $employees = Employee::where('store_id',$storeid)->get();
        $parttimers = Parttimer::where('store_id',$storeid)->get();

        return view('employeesManagementPassView', compact('employees', 'parttimers'));
    }

    //<--上書き更新

}
