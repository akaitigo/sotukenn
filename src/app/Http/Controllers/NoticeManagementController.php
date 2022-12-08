<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\admin;
use App\Models\Store;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeManagementController extends Controller
{
    
    /* 通知管理 */
    public function management()
    {
        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $notices = Notice::where('store_id',$storeid)->get();
        return view('noticeManagement',compact('notices'));
    }

    /* 通知編集 */
    public function edit(Request $request)
    {
        $getId = $request->input('notiChange');
        $notices = Notice::where('id',$getId)->get();
        return view('noticeEdit',compact('notices'));
    }
    /* 通知更新 */
    public function update(Request $request)
    {
        $getId = $request->input('updateId');
        $inputContent = $request->input('newNotiContent');
        $inputTarget = $request->input('newNotiTarget');
        $inputMessage = $request->input('newNotiMessage');
        $selectNotiDay = $_POST['newNotiDay'];
        $updateNotice = Notice::where('id',$getId)->get();

        foreach ($updateNotice as $remp) {
            if (!(is_null($inputContent))) {
                $changeConfirmContent = $inputContent;
                \DB::table('notices')
                ->where('id', $getId)
                ->update([
                    'content' => $changeConfirmContent
                ]);
            }
            if (!(is_null($inputTarget))) {
                $changeConfirmTarget = $inputTarget;
                \DB::table('notices')
                ->where('id', $getId)
                ->update([
                    'target' => $changeConfirmTarget
                ]);
            }
            if (!(is_null($inputMessage))) {
                $changeConfirmMessage = $inputMessage;
                \DB::table('notices')
                ->where('id', $getId)
                ->update([
                    'message' => $changeConfirmMessage
                ]);
            }
            \DB::table('notices')
            ->where('id', $getId)
            ->update([
                'noticeday' => $selectNotiDay
            ]);
            
        }

        $adminid=Auth::guard('admin')->id();
        $storeid = admin::where('id',$adminid)->value('store_id');
        $notices = Notice::where('store_id',$storeid)->get();
        return view('noticeManagement',compact('notices'));

    }
    /* 通知削除 */
    public function delete(Request $request)
    {
        return view('noticeManagement');
    }
}