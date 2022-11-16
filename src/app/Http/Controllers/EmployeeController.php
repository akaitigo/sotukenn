<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Parttimer;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $parttimers = Parttimer::all();



        foreach ($parttimers as $part) {
            $decrypted = Crypt::decryptString($part->password); //パスワードの復元
            $part->password = $decrypted;
        }


        // foreach ($employees as $emp) {
        //     $decrypted = Crypt::decryptString($emp->password); //パスワードの復元
        //     $emp->password = $decrypted;
        // }




        return view('employeesManagement', compact('employees', 'parttimers'));
    }
}
