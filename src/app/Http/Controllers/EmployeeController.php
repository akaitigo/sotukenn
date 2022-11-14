<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Parttimer;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::get();
        $parttimers = Parttimer::all();
        foreach ($parttimers as $parttimer) {
            echo "<br/>{$parttimer->parttimer_name}の仕事たち：";
        }

        foreach ($parttimer->Jobs as $job) {
            echo "{$job->job_id}";
            echo "a";
        }
        return view('employeesManagement', compact('employees', 'parttimers'));
    }
}
