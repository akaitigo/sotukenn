<?php

namespace App\Http\Controllers;

class NoticeManagementController extends Controller
{
    
    /* 通知管理 */
    public function management()
    {
        return view('noticeManagement');
    }

    /* 通知編集 */
    public function edit()
    {
        return view('noticeEdit');
    }
}