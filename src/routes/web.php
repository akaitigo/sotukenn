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
    return view('title');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//メニューバールーティング
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, '#'])->name('calendar');                                   //カレンダー
Route::get('/employeesManagement', [App\Http\Controllers\employeesManagementController::class, '#'])->name('employeesManagement');  //従業員管理
Route::get('/noticeManagement', [App\Http\Controllers\noticeManagementController::class, '#'])->name('noticeManagement');           //通知管理
Route::get('/submittedShift', [App\Http\Controllers\submittedShiftController::class, '#'])->name('submittedShift');                 //提出シフト管理
Route::get('/ShiftView', [App\Http\Controllers\ShiftViewController::class, '#'])->name('ShiftView');                                //シフト閲覧
Route::get('/ShiftCreateMenu', [App\Http\Controllers\ShiftCreateMenuController::class, '#'])->name('ShiftCreateMenu');              //シフト作成

