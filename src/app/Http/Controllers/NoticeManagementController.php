<?php

namespace App\Http\Controllers;

class ShiftController extends Controller
{
    
    /* 通知管理 */
    public function management()
    {
        return view('submittedShiftEdit');
    }

    /* 通知編集 */
    public function edit()
    {
        return view('submittedShiftEdit');
    }
}