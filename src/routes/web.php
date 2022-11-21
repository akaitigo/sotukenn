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
//Route::get('/', [App\Http\Controllers\Controller::class, 'index'])->name('home');


Auth::routes();

Route::get('/register', "App\Http\Controllers\RegisterFormController@show")->name('register.show');
Route::post('/register', "App\Http\Controllers\RegisterFormController@post")->name('register.post');

Route::get('/register/confirm', "App\Http\Controllers\RegisterFormController@confirm")->name("register.confirm");
Route::post('/register/confirm', "App\Http\Controllers\Auth\RegisterController@register")->name("register");
Route::post('/register/confirm', "App\Http\Controllers\RegisterFormController@send")->name("register.send");

Route::get('/register/thanks', "App\Http\Controllers\RegisterFormController@complete")->name("register.complete");


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//メニューバー(header)
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, '#'])->name('calendar');                                   //カレンダー

Route::get('/employeesManagementPassView', [App\Http\Controllers\EmployeeController::class, 'empPasswordView'])->name('employeesManagementPassView');  //従業員管理パスワード表示・管理
Route::get('/employeesManagement', [App\Http\Controllers\EmployeeController::class, 'empPasswordNotView'])->name('employeesManagementPassNotView');  //従業員管理パスワード表示・管理-->従業員管理パスワード非表示
Route::get('/employeesManegementChange', [App\Http\Controllers\EmployeeController::class, 'empChange'])->name('employeesManagementChange'); //従業員管理パスワード表示・管理-->従業員情報変更
Route::get('/partManegementChange', [App\Http\Controllers\EmployeeController::class, 'partChange'])->name('partManagementChange');
Route::post('/employeesManagementDelete', [App\Http\Controllers\EmployeeController::class, 'empDelete'])->name('employeesManagementDelete'); //従業員管理パスワード表示・管理-->従業員情報変更
Route::post('/employeesManegement', [App\Http\Controllers\EmployeeController::class, 'partDelete'])->name('partManagementDelete'); //従業員管理パスワード表示・管理-->従業員情報変更


Route::get('/noticeManagement', [App\Http\Controllers\NoticeManagementController::class, 'management'])->name('noticeManagement');           //通知管理
Route::get('/noticeEdit', [App\Http\Controllers\NoticeManagementController::class, 'edit'])->name('noticeEdit');                       //通知編集

Route::get('/submittedShift', [App\Http\Controllers\ShiftController::class, 'management'])->name('submittedShift');                          //提出シフト管理
Route::get('/submittedShiftEdit', [App\Http\Controllers\ShiftController::class, 'setting'])->name('submittedShiftEdit');            //シフト設定

Route::get('/shiftView', [App\Http\Controllers\ShiftController::class, 'view'])->name('shiftView');                                    //シフト閲覧
Route::get('/shiftEdit', [App\Http\Controllers\ShiftController::class, 'edit'])->name('shiftEdit');                                    //シフト編集

Route::get('/shiftCreateMenu', [App\Http\Controllers\ShiftController::class, 'menu'])->name('shiftCreateMenu');                        //シフト作成メニュー
Route::get('/shiftCreate', [App\Http\Controllers\ShiftController::class, 'create'])->name('shiftCreate');                                //シフト作成
Route::get('/candidacyView', [App\Http\Controllers\ShiftController::class, 'multiple'])->name('candidacyView');                            //シフト候補表示


//ボタンクリック&待ち時間遷移
Route::get('/submittedShiftDetail', [App\Http\Controllers\ShiftController::class, 'detail'])->name('submittedShiftDetail');              //提出シフト管理---→提出済みシフト確認
Route::get('/candidacyShiftChoice', [App\Http\Controllers\ShiftController::class, 'choice'])->name('candidacyShiftChoice');              //シフト候補表示---→シフト候補詳細
