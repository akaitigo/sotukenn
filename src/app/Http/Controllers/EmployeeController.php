<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class EmployeeController extends Controller
{

    //パスワードを表示、複合化
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
        foreach ($employees as $emp) {
            $decrypted = Crypt::decryptString($emp->password); //empパスワードの復元
            $emp->password = $decrypted;
        }
        return view('employeesManagementChange', compact('employees', 'allJob', 'empChangeIden', 'partChangeIden'));
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

    //<-削除
}
