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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//メニューバールーティング
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, '#'])->name('calendar');                                   //カレンダー
Route::get('/employeesManagement', [App\Http\Controllers\employeesManagementController::class, '#'])->name('employeesManagement');  //従業員管理
Route::get('/noticeManagement', [App\Http\Controllers\noticeManagementController::class, '#'])->name('noticeManagement');           //通知管理
Route::get('/submittedShift', [App\Http\Controllers\submittedShiftController::class, '#'])->name('submittedShift');                 //提出シフト管理
Route::get('/ShiftView', [App\Http\Controllers\ShiftViewController::class, '#'])->name('ShiftView');                                //シフト閲覧
Route::get('/ShiftCreateMenu', [App\Http\Controllers\ShiftCreateMenuController::class, '#'])->name('ShiftCreateMenu');              //シフト作成メニュー

//メニューバープルダウン
Route::get('/noticeEdit', [App\Http\Controllers\noticeManagementController::class, '#'])->name('noticeEdit');                       //通知管理---→通知編集
Route::get('/submittedShiftEdit', [App\Http\Controllers\submittedShiftController::class, '#'])->name('submittedShiftEdit');         //シフト設定
Route::get('/submittedShiftDetail', [App\Http\Controllers\submittedShiftController::class, '#'])->name('submittedShiftDetail');     //提出済みシフト確認
Route::get('/ShiftCreate', [App\Http\Controllers\ShiftViewController::class, '#'])->name('ShiftCreate');                            //シフト作成
Route::get('/candidacyView', [App\Http\Controllers\ShiftViewController::class, '#'])->name('candidacyView');                        //シフト候補表示

Route::get('/noticeEdit', [App\Http\Controllers\noticeManagementController::class, '#'])->name('noticeEdit');                       //通知管理---→通知編集
Route::get('/noticeManagement', [App\Http\Controllers\noticeManagementController::class, '#'])->name('noticeManagement');           //通知編集---→通知管理
Route::get('/submittedShiftEdit', [App\Http\Controllers\submittedShiftController::class, '#'])->name('submittedShiftEdit');         //提出シフト管理---→シフト設定
Route::get('/submittedShift', [App\Http\Controllers\submittedShiftController::class, '#'])->name('submittedShift');                 //提出シフト管理---→シフト設定








