<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Notice;

class NoticeManagementController extends Controller
{
    
    /* 通知管理 */
    public function management()
    {
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $notices = Notice::where('id',$storeid)->
        ();
        return view('noticeManagement',compact('notices'));
    }

    /* 通知編集 */
    public function edit()
    {
        return view('noticeEdit');
    }
}