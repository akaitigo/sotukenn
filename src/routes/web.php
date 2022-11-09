<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('header');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//メニューバー
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, '#'])->name('calendar');                                   //カレンダー
Route::get('/employeesManagement', [App\Http\Controllers\EmployeesManagementController::class, '#'])->name('employeesManagement');  //従業員管理
Route::get('/noticeManagement', [App\Http\Controllers\NoticeManagementController::class, '#'])->name('noticeManagement');           //通知管理
Route::get('/submittedShift', [App\Http\Controllers\ShiftController::class, '#'])->name('submittedShift');                          //提出シフト管理
Route::get('/shiftView', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftView');                                    //シフト閲覧
Route::get('/shiftCreateMenu', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftCreateMenu');                        //シフト作成メニュー

//test/ classの後ろにコントローラーのメソッド名
Route::get('/employeesManagement', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employeesManagement');                                   //カレンダー
//test//


//メニューバープルダウン
Route::get('/noticeEdit', [App\Http\Controllers\NoticeManagementController::class, '#'])->name('noticeEdit');                       //通知管理---→通知編集
Route::get('/submittedShiftEdit', [App\Http\Controllers\ShiftController::class, '#'])->name('submittedShiftEdit');                  //シフト設定
Route::get('/shiftEdit', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftEdit');                                    //シフト編集
Route::get('/shiftCreate', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftCreate');                                //シフト作成
Route::get('/candidacyView', [App\Http\Controllers\ShiftController::class, '#'])->name('candidacyView');                            //シフト候補表示

//ボタンクリック&待ち時間遷移
Route::get('/noticeEdit', [App\Http\Controllers\NoticeManagementController::class, '#'])->name('noticeEdit');                       //通知管理---→通知編集
Route::get('/noticeManagement', [App\Http\Controllers\NoticeManagementController::class, '#'])->name('noticeManagement');           //通知編集---→通知管理
<<<<<<< HEAD
Route::get('/submittedShiftEdit', [App\Http\Controllers\SubmittedShiftController::class, '#'])->name('submittedShiftEdit');         //提出シフト管理---→シフト設定
Route::get('/submittedShift', [App\Http\Controllers\SubmittedShiftController::class, '#'])->name('submittedShift');                 //シフト設定---→提出シフト管理
Route::get('/submittedShiftDetail', [App\Http\Controllers\SubmittedShiftController::class, '#'])->name('submittedShiftDetail');     //提出シフト管理---→提出済みシフト確認
Route::get('/submittedShift', [App\Http\Controllers\SubmittedShiftController::class, '#'])->name('submittedShift');                 //提出済みシフト確認---→提出シフト管理
Route::get('/shiftEdit', [App\Http\Controllers\ShiftViewController::class, '#'])->name('shiftEdit');                                //シフト閲覧---→シフト編集
Route::get('/shiftView', [App\Http\Controllers\ShiftViewController::class, '#'])->name('shiftView');                                //シフト編集---→シフト閲覧
Route::get('/shiftCreate', [App\Http\Controllers\ShiftCreateMenuController::class, '#'])->name('shiftCreate');                      //シフト作成メニュー---→シフト作成
Route::get('/candidacyView', [App\Http\Controllers\ShiftCreateMenuController::class, '#'])->name('candidacyView');                  //シフト作成メニュー---→シフト候補表示
Route::get('/candidacyShiftChoice', [App\Http\Controllers\ShiftCreateMenuController::class, '#'])->name('candidacyShiftChoice');    //シフト候補表示---→シフト候補詳細
Route::get('/shiftView', [App\Http\Controllers\ShiftCreateMenuController::class, '#'])->name('shiftView');                          //シフト候補詳細（選択）---→シフト閲覧
=======
Route::get('/submittedShiftEdit', [App\Http\Controllers\ShiftController::class, '#'])->name('submittedShiftEdit');                  //提出シフト管理---→シフト設定
Route::get('/submittedShift', [App\Http\Controllers\ShiftController::class, '#'])->name('submittedShift');                          //シフト設定---→提出シフト管理
Route::get('/submittedShiftDetail', [App\Http\Controllers\ShiftController::class, '#'])->name('submittedShiftDetail');              //提出シフト管理---→提出済みシフト確認
Route::get('/submittedShift', [App\Http\Controllers\ShiftController::class, '#'])->name('submittedShift');                          //提出済みシフト確認---→提出シフト管理
Route::get('/shiftEdit', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftEdit');                                    //シフト閲覧---→シフト編集
Route::get('/shiftView', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftView');                                    //シフト編集---→シフト閲覧
Route::get('/shiftCreate', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftCreate');                                //シフト作成メニュー---→シフト作成
Route::get('/candidacyView', [App\Http\Controllers\ShiftController::class, '#'])->name('candidacyView');                            //シフト作成---→シフト候補表示
Route::get('/candidacyView', [App\Http\Controllers\ShiftController::class, '#'])->name('candidacyView');                            //シフト作成メニュー---→シフト候補表示
Route::get('/candidacyShiftChoice', [App\Http\Controllers\ShiftController::class, '#'])->name('candidacyShiftChoice');              //シフト候補表示---→シフト候補詳細
Route::get('/shiftView', [App\Http\Controllers\ShiftController::class, '#'])->name('shiftView');                                    //シフト候補詳細（選択）---→シフト閲覧




>>>>>>> f34a4e19002419a039ffeebdde74a6b7dd9db589
