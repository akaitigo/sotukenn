<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\admin;
use function PHPUnit\Framework\isNull;
use App\Http\Controllers\ryu_test\CalendarApiController;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:employee')->except('logout');
        $this->middleware('guest:parttimer')->except('logout');
    }
    //admin用login
    public function showAdminLoginForm()
    {
        return view('auth.login', ['authgroup' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        // dump($request);
        // echo($request['email']);
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);
        // dump($credentials);
        // exit;

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $adminid=Auth::guard('admin')->id();
            $storeid = admin::where('id',$adminid)->value('store_id');
            $submitlimit = Store::where('id',$storeid)->value('submissionlimit');
            $stores = Store::find($storeid);
            $user=Auth::guard('admin')->user();
            // dump($user);
            // echo $user->refresh_token;
            // return ;
            if(empty($user->refresh_token)){
                $api = new CalendarApiController();
                return $api->redirectToGoogle();
            }
            if(is_null($submitlimit)) {
                return view('submittedShiftEdit',compact('stores'));
            }else {
                return redirect(route('home'));
            }
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('email', 'remember'));
    }
    //employee用login
    public function showEmployeeLoginForm()
    {
        return view('auth.login', ['authgroup' => 'employee']);
    }

    public function employeeLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password])) {
            dump(Auth::guard('employee')->user());
            dump(Auth::guard('employee')->user()->getTable());
            return ;
            return redirect(route('home'));
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('email', 'remember'));
    }
    //parttimer用login
    public function showParttimerLoginForm()
    {
        return view('auth.login', ['authgroup' => 'parttimer']);
    }

    public function parttimerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if (Auth::guard('parttimer')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect(route('home'));
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return back()->withInput($request->only('email', 'remember'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('/admin/login');
    }
    public function tokenCheck($user){
        $client = tokenClient();
        if($user->getTable()=='employees'){
            if(is_null($user->refresh_token)){

            }else{

            }
               
        }else if($user->getTable()=='parttimer'){
            
        }
    }
}
