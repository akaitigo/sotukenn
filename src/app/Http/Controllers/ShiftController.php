<?php

namespace App\Http\Controllers;
use App\Models\Store;

class ShiftController extends Controller
{
    
     /* 提出シフト管理 */
    public function management()
    {
        return view('submittedShift');
    }

    /* シフト設定 */
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