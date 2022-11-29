<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Parttimer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        // $this->middleware('guest');
        $this->middleware('guest:admin')->except(
            
            'employeeValidator',
            'showEmployeeRegisterForm',
            'registerEmployee',
            'createEmployee',
            'registeredEmployee',

            'parttimerValidator',
            'showParttimerRegisterForm',
            'registerParttimer',
            'createParttimer',
            'registeredParttimer');
        $this->middleware('guest:employee')->except(
            'parttimerValidator',
            'showParttimerRegisterForm',
            'registerParttimer',
            'createParttimer',
            'registeredParttimer');
        $this->middleware('guest:parttimer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'enterprise' => $data['enterprise'],
            'password' => Hash::make($data['password']),

        ]);
    }
    //admin用
    protected function adminValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showAdminRegisterForm()
    {
        return view('auth.register', ['authgroup' => 'admin']);
    }

    public function registerAdmin(Request $request)
    {
        $this->adminValidator($request->all())->validate();

        event(new Registered($user = $this->createAdmin($request->all())));

        Auth::guard('admin')->login($user);

        if ($response = $this->registeredAdmin($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect(route('home'));
    }

    protected function createAdmin(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "created_at" =>  Carbon::now(),
            "updated_at" =>  Carbon::now(),
        ]);
    }

    protected function registeredAdmin(Request $request, $user)
    {
        //
    }
    //employee用
    protected function employeeValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showEmployeeRegisterForm()
    {
        return view('auth.register', ['authgroup' => 'employee']);
    }

    public function registerEmployee(Request $request)
    {
        $this->employeeValidator($request->all())->validate();

        event(new Registered($user = $this->createEmployee($request->all())));

        Auth::guard('employee')->login($user);

        if ($response = $this->registeredEmployee($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect(route('home'));
    }

    protected function createEmployee(array $data)
    {
        return Employee::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "created_at" =>  Carbon::now(),
            "updated_at" =>  Carbon::now(),
        ]);
    }

    protected function registeredEmployee(Request $request, $user)
    {
        //
    }
    //parttimer用
    protected function parttimerValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:parttimers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function showParttimerRegisterForm()
    {
        return view('auth.register', ['authgroup' => 'parttimer']);
    }

    public function registerParttimer(Request $request)
    {
        $this->parttimerValidator($request->all())->validate();

        event(new Registered($user = $this->createParttimer($request->all())));

        Auth::guard('parttimer')->login($user);

        if ($response = $this->registeredParttimer($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect(route('home'));
    }

    protected function createParttimer(array $data)
    {
        return Parttimer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "created_at" =>  Carbon::now(),
            "updated_at" =>  Carbon::now(),
        ]);
    }

    protected function registeredparttimer(Request $request, $user)
    {
        //
    }
}
