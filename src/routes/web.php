<?php

use Illuminate\Support\Facades\Route;
use App\Models\Store;

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
//googleapi
Route::get('/api', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'test']);
Route::get('/api/redirect', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'redirectToGoogle']);
Route::get('/api/index', [App\Http\Controllers\GoogleApi\TokenController::class, 'test']);
Route::get('/api/saveToken', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'saveToken']);
// Route::get('/api', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'test']);
// Route::get('/api/redirect', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'redirectToGoogle']);
// Route::get('/api/index', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'handleGoogleCallback']);
// Route::get('/api/saveToken', [App\Http\Controllers\ryu_test\CalendarApiController::class, 'saveToken']);
Route::get('/api/callbuck', [App\Http\Controllers\GoogleApi\TokenController::class, 'saveRefreshToken']);
Route::get('/submittedShiftEdit', function () {
    $stores = Store::find(Auth::guard('admin')->user()->store_id);
    return view('submittedShiftEdit', compact('stores'));
});

Route::get('/', [App\Http\Controllers\tokuchan\MainController::class, 'main']);

//line
Route::post('/line/webhook', 'App\Http\Controllers\LineWebhookController@message')->name('line.webhook.message');
Route::get('/messages', 'App\Http\Controllers\MessageController@index1')->name('message.index1'); //通知管理
Route::get('/messagessent', 'App\Http\Controllers\MessageController@show')->name('messagessent');
Route::get('/partMessagessent', 'App\Http\Controllers\MessageController@partshow')->name('partMessagessent');
Route::post('/message/{lineUserId}', 'App\Http\Controllers\MessageController@create')->name('message.create');
Route::get('/loginCheck/{lineUserId}', 'App\Http\Controllers\MessageController@login')->name('login.check');
Route::post('/loginCheck', 'App\Http\Controllers\MessageController@loginCheck')->name('loginCheck');
//-<line


Route::get('/title', function () {
    return view('title');
});

Route::get('home', function () {
    return view('header');
})->name('home');

Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
//adiminしか使えないroute
Route::middleware('auth:admin')->group(function () {
    Route::get('employee/register', [App\Http\Controllers\Auth\RegisterController::class, 'showEmployeeRegisterForm'])->name('employee.register');
    Route::post('employee/register', [App\Http\Controllers\Auth\RegisterController::class, 'registerEmployee'])->name('employee-register');
    Route::get('/informationShare', [App\Http\Controllers\informationShareController::class, 'informationShareView'])->name('informationShare');
    Route::get('/employeesManagementPassView', [App\Http\Controllers\EmployeeController::class, 'empPasswordView'])->name('employeesManagementPassView');  //従業員管理パスワード表示・管理
    Route::get('/employeesManagement', [App\Http\Controllers\EmployeeController::class, 'empPasswordNotView'])->name('employeesManagementPassNotView');  //従業員管理パスワード表示・管理-->従業員管理パスワード非表示
    Route::get('/employeesManegementChange', [App\Http\Controllers\EmployeeController::class, 'empChange'])->name('employeesManagementChange'); //従業員管理パスワード表示・管理-->従業員情報変更(emp)
    Route::get('/partManegementChange', [App\Http\Controllers\EmployeeController::class, 'partChange'])->name('partManagementChange'); //従業員管理パスワード表示・管理-->従業員情報変更(part)
    Route::post('/employeesManagementDelete', [App\Http\Controllers\EmployeeController::class, 'empDelete'])->name('employeesManagementDelete'); //従業員管理パスワード表示・管理-->従業員情報変更(削除)
    Route::post('/employeesManegement', [App\Http\Controllers\EmployeeController::class, 'partDelete'])->name('partManagementDelete'); //従業員管理パスワード表示・管理-->従業員情報変更(削除)
    Route::post('/employeesManegementUpdate', [App\Http\Controllers\EmployeeController::class, 'empUpdate'])->name('employeesManegementUpdate'); //従業員情報変更-->情報上書き更新(emp)
    Route::post('/parttimersManegementUpdate', [App\Http\Controllers\EmployeeController::class, 'partUpdate'])->name('parttimersManegementUpdate'); //従業員情報変更-->情報上書き更新(part)
    //line
    // Route::post('/line/webhook', 'App\Http\Controllers\LineWebhookController@message')->name('line.webhook.message');
    // Route::get('/messages', 'App\Http\Controllers\MessageController@index1')->name('message.index1'); //通知管理
    // Route::get('/messagessent', 'App\Http\Controllers\MessageController@show')->name('messagessent');
    // Route::get('/partMessagessent', 'App\Http\Controllers\MessageController@partshow')->name('partMessagessent');
    // Route::post('/message/{lineUserId}', 'App\Http\Controllers\MessageController@create')->name('message.create');
    // Route::get('/loginCheck/{lineUserId}', 'App\Http\Controllers\MessageController@login')->name('login.check');
    // Route::post('/loginCheck', 'App\Http\Controllers\MessageController@loginCheck')->name('loginCheck');
});
//adminかemployeeしか使えないroute
Route::middleware('auth:employee,admin')->group(function () {
    Route::get('parttimer/register', [App\Http\Controllers\Auth\RegisterController::class, 'showParttimerRegisterForm'])->name('parttimer.register');
    Route::post('parttimer/register', [App\Http\Controllers\Auth\RegisterController::class, 'registerParttimer'])->name('parttimer-register');
    
});
//Route::get('/', [App\Http\Controllers\Controller::class, 'index'])->name('home');

//adminの認証route
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm'])->name('login');
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegisterForm'])->name('register');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin']);
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'registerAdmin'])->name('admin-register');
    Route::get('password/reset', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'reset'])->name('password.update');
});
//employeeの認証route
Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showEmployeeLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'employeeLogin']);
    // Route::get('password/reset', [App\Http\Controllers\Auth\EmployeeForgotPasswordController::class, 'showLinkRequestForm'])->name('employee.password.request');
    // Route::post('password/email', [App\Http\Controllers\Auth\EmployeeForgotPasswordController::class, 'sendResetLinkEmail'])->name('employee.password.email');
    // Route::get('password/reset/{token}', [App\Http\Controllers\Auth\EmployeeResetPasswordController::class, 'showResetForm'])->name('employee.password.reset');
    // Route::post('password/reset', [App\Http\Controllers\Auth\EmployeeResetPasswordController::class, 'reset'])->name('employee.password.update');
});
//parttimerの認証route
Route::prefix('parttimer')->name('parttimer.')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showParttimerLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'parttimerLogin']);
    // Route::get('password/reset', [App\Http\Controllers\Auth\ParttimerForgotPasswordController::class, 'showLinkRequestForm'])->name('parttimer.password.request');
    // Route::post('password/email', [App\Http\Controllers\Auth\ParttimerForgotPasswordController::class, 'sendResetLinkEmail'])->name('parttimer.password.email');
    // Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ParttimerResetPasswordController::class, 'showResetForm'])->name('parttimer.password.reset');
    // Route::post('password/reset', [App\Http\Controllers\Auth\ParttimerResetPasswordController::class, 'reset'])->name('parttimer.password.update');
});
Route::get('login', [App\Http\Controllers\RedirectController::class, 'toLogin']);
Route::get('register', [App\Http\Controllers\RedirectController::class, 'toRegister']);

// Route::get('/register', "App\Http\Controllers\RegisterFormController@show")->name('register.show');
// Route::post('/register', "App\Http\Controllers\RegisterFormController@post")->name('register.post');

// Route::get('/register/confirm', "App\Http\Controllers\RegisterFormController@confirm")->name("register.confirm");
// Route::post('/register/confirm', "App\Http\Controllers\Auth\RegisterController@register")->name("register");
// Route::post('/register/confirm', "App\Http\Controllers\RegisterFormController@send")->name("register.send");

// Route::get('/register/thanks', "App\Http\Controllers\RegisterFormController@complete")->name("register.complete");


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//メニューバー(header)
Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'foovar'])->name('calendar');                                   //カレンダー

// Route::get('/employeesManagementPassView', [App\Http\Controllers\EmployeeController::class, 'empPasswordView'])->name('employeesManagementPassView');  //従業員管理パスワード表示・管理
// Route::get('/employeesManagement', [App\Http\Controllers\EmployeeController::class, 'empPasswordNotView'])->name('employeesManagementPassNotView');  //従業員管理パスワード表示・管理-->従業員管理パスワード非表示
// Route::get('/employeesManegementChange', [App\Http\Controllers\EmployeeController::class, 'empChange'])->name('employeesManagementChange'); //従業員管理パスワード表示・管理-->従業員情報変更(emp)
// Route::get('/partManegementChange', [App\Http\Controllers\EmployeeController::class, 'partChange'])->name('partManagementChange'); //従業員管理パスワード表示・管理-->従業員情報変更(part)
// Route::post('/employeesManagementDelete', [App\Http\Controllers\EmployeeController::class, 'empDelete'])->name('employeesManagementDelete'); //従業員管理パスワード表示・管理-->従業員情報変更(削除)
// Route::post('/employeesManegement', [App\Http\Controllers\EmployeeController::class, 'partDelete'])->name('partManagementDelete'); //従業員管理パスワード表示・管理-->従業員情報変更(削除)
// Route::post('/employeesManegementUpdate', [App\Http\Controllers\EmployeeController::class, 'empUpdate'])->name('employeesManegementUpdate'); //従業員情報変更-->情報上書き更新(emp)
// Route::post('/parttimersManegementUpdate', [App\Http\Controllers\EmployeeController::class, 'partUpdate'])->name('parttimersManegementUpdate'); //従業員情報変更-->情報上書き更新(part)



Route::get('/noticeManagement', [App\Http\Controllers\NoticeManagementController::class, 'management'])->name('noticeManagement');           //通知管理
Route::get('/noticeEdit', [App\Http\Controllers\NoticeManagementController::class, 'edit'])->name('noticeEdit');                       //通知編集
Route::post('/noticeManagementUpdate', [App\Http\Controllers\NoticeManagementController::class, 'update'])->name('noticeUpdate');                       //通知更新
Route::post('/noticeManagementDelete', [App\Http\Controllers\NoticeManagementController::class, 'delete'])->name('noticeManagementDelete');                       //通知削除

Route::get('/submittedShift', [App\Http\Controllers\ShiftController::class, 'management'])->name('submittedShift');                          //提出シフト管理

Route::get('/shiftView', [App\Http\Controllers\tokuchan\MainController::class, 'main'])->name('shiftView');                                    //シフト閲覧
Route::get('/shiftEdit', [App\Http\Controllers\ShiftController::class, 'edit'])->name('shiftEdit');                                    //シフト編集

Route::get('/shiftCreateMenu', [App\Http\Controllers\ShiftController::class, 'menu'])->name('shiftCreateMenu');                        //シフト作成メニュー
Route::get('/shiftCreate', [App\Http\Controllers\ShiftController::class, 'create'])->name('shiftCreate');                                //シフト作成
Route::get('/candidacyView', [App\Http\Controllers\ShiftController::class, 'multiple'])->name('candidacyView');                            //シフト候補表示


//ボタンクリック&待ち時間遷移
Route::post('/calendar', [App\Http\Controllers\ShiftController::class, 'firstsetting'])->name('firstsetting');
Route::get('/submittedShiftDetail', [App\Http\Controllers\ShiftController::class, 'detail'])->name('submittedShiftDetail');              //提出シフト管理---→提出済みシフト確認
Route::get('/candidacyShiftChoice', [App\Http\Controllers\ShiftController::class, 'choice'])->name('candidacyShiftChoice');              //シフト候補表示---→シフト候補詳細



Route::post('/', "App\Http\Controllers\SettingController@update")->name('setting.update');

Route::post('settingupdate', "App\Http\Controllers\SettingController@update")->name('setting.update');
Route::get('settingselect', "App\Http\Controllers\SettingController@select")->name('setting.select');

