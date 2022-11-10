<?php

namespace App\Http\Controllers;

class ShiftController extends Controller
{
    
     /* 提出シフト管理 */
    public function management()
    {
        return view('submittedShiftEdit');
    }

    /* シフト設定 */
    public function setting()
    {
        return view('submittedShiftEdit');
    }

    /* 提出済みシフト確認 */
    public function detail()
    {
        return view('submittedShiftEdit');
    }

    /* シフト閲覧 */
    public function view()
    {
        return view('submittedShiftEdit');
    }

    /* シフト作成メニュー */
    public function menu()
    {
        return view('submittedShiftEdit');
    }

    /* シフト作成 */
    public function create()
    {
        return view('submittedShiftEdit');
    }

    /* シフト候補表示 */
    public function multiple()
    {
        return view('submittedShiftEdit');
    }

    /* シフト候補詳細 */
    public function choice()
    {
        return view('submittedShiftEdit');
    }

}