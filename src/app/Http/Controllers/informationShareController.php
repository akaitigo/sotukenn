<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\InformationShare;

class informationShareController extends Controller
{
    public function informationShareView()
    {

        return view('informationShare');
    }

    public function informationShareRegister()
    {
        $user = Auth::user();
        return view('informationRegisterView', compact('user'));
    }

    public function informationSave(Request $request)
    {
        $getEmail = $request->input('registerUser');
        $getUserEmp = Employee::where('email', '=', $getEmail)->get();
        $getUserPart = Parttimer::where('email', '=', $getEmail)->get();

        $information = new InformationShare;
        $information->shareName('test');
    }
}
