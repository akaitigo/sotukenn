<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = "test";


        //  Employee::all();
        return view('employeesManagement', compact('employees'));
    }
}
