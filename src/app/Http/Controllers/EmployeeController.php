<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $employee = Employee::where('employee_id','2')->first();
        
        dd($employee);

    }
}
