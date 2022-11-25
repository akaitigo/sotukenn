<?php

namespace App\Http\Controllers;
use App\Models\Store;
use Illuminate\Http\Request;

class ShiftController extends Controller
{

    private $formItems = ["workstarttime", "workendtime", "submissionlimit","vote"];

    
     /* 提出シフト管理 */
    public function management()
    {
        return view('submittedShift');
    }

    /* シフト設定 */
    public function firstsetting(Request $request)
    {

        $data = $request->only($this->formItems);
        $vote=$request->input('vote');
        if(is_null($vote) ){
            $data['vote'] = 0;
        }else{
            $data['vote'] = 1;
        }
        /*認証コード
        Auth::guard(admins)->user()->id
        $store_id = DB::table('admin)->where('store_id');
        \DB::table('stores')
            ->where('id', $store_id)
            ->update([
                'workstarttime' => $data['workstarttime'],
                'workendtime' => $data['workendtime'],
                'submissionlimit' => $data['submissionlimit'],
                'vote' => $data['vote']     
            ]);
        */
        \DB::table('stores')
            ->where('id', 1)
            ->update([
                'workstarttime' => $data['workstarttime'],
                'workendtime' => $data['workendtime'],
                'submissionlimit' => $data['submissionlimit'],
                'vote' => $data['vote']
            ]);
        return view('calendar');
    }

    public function setting()
    {
        $stores = Store::find(1);
        return view('submittedShiftEdit',compact('stores'));
    }

    /* 提出済みシフト確認 */
    public function detail()
    {
        return view('submittedShiftDetail');
    }

    /* シフト閲覧 */
    public function view()
    {
        return view('shiftView');
    }

    /* シフト編集 */
    public function edit()
    {
        return view('shiftEdit');
    }

    /* シフト作成メニュー */
    public function menu()
    {
        return view('shiftCreateMenu');
    }

    
    /* シフト作成 */
    public function create()
    {
        return view('shiftCreate');
    }

    /* シフト候補表示 */
    public function multiple()
    {
        return view('candidacyView');
    }

    /* シフト候補詳細 */
    public function choice()
    {
        return view('candidacyShiftChoice');
    }

}