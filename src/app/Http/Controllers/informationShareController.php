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

        $user = Auth::user();
        $userStore = $user->store_id;
        $information = InformationShare::where('store_id', '=', $userStore)->get();
        dump($information);
        return view('informationShare', compact('information'));
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
        $inputSpan = $request->input('days');
        $inputShareContent = $request->input('sharename');
        $inputText = $request->input('massage');
        foreach ($getUserEmp as $emp) {
            \DB::table('informationshares')->insert([
                'shareSpan' => $inputSpan, //表示期間
                'shareContent' => $inputShareContent, //掲示明
                'registerUser' => $emp->name, //登録者
                'shareText' => $inputText,
                'registrationDate' => $today = date("Y-m-d H:i:s")

            ]);
        }

        foreach ($getUserPart as $part) {
            \DB::table('informationshares')->insert([
                'shareSpan' => $inputSpan, //表示期間
                'shareContent' => $inputShareContent, //掲示明
                'registerUser' => $emp->name, //登録者
                'shareText' => $inputText,
                'registrationDate' => $today = date("Y-m-d H:i:s")

            ]);
        }
    }
}
