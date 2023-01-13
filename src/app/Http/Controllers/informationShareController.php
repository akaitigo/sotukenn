<?php


namespace App\Http\Controllers;





use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;

use App\Models\InformationShare;
use Carbon\Carbon;
use App\Models\Message;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class informationShareController extends Controller
{
    public function informationShareView()
    {

        $user = Auth::user();

        $userStore = $user->store_id;
        $userEmail=$user->email;
        $information = InformationShare::where('store_id', '=', $userStore)->get();
        return view('informationShare', compact('information','userEmail'));
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
        $now = Carbon::now();
        $time = Carbon::now();

        foreach ($getUserEmp as $emp) {
            \DB::table('informationshares')->insert([
                'shareSpan' => $inputSpan, //表示期間
                'shareContent' => $inputShareContent, //掲示明
                'registerUser' => $emp->name, //登録者
                'shareText' => $inputText,
                'registrationDate' => $now,
                'daysRemaining' => $time->addDays($inputSpan), //残り日数
                'email'=>$emp->email
            ]);
        }

        foreach ($getUserPart as $part) {
            \DB::table('informationshares')->insert([
                'shareSpan' => $inputSpan, //表示期間
                'shareContent' => $inputShareContent, //掲示明
                'registerUser' => $emp->name, //登録者
                'shareText' => $inputText,
                'registrationDate' => $now,
                'daysRemaining' => $time->addDays($inputSpan), //残り日数
                'email'=>$part->email
            ]);
        }

        $user = Auth::user();
        $userStore = $user->store_id;


        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

        $lineEmp = Employee::where('lineRegister', '=', '3')->get();
        $linePart = Parttimer::where('lineRegister', '=', '3')->get();
        foreach ($lineEmp as $emp) {
            if ($emp->store_id == $userStore) {
                $textMessageBuilder = new TextMessageBuilder("新規の掲示が登録されました。\n確認をお願いします");
                $response = $bot->pushMessage($emp->lineUserId, $textMessageBuilder);
                $textMessageBuilder = new TextMessageBuilder("掲示名：" . $inputShareContent . "\n掲示内容：" . $inputText . "\n\n登録者：" . $emp->name);
                $response = $bot->pushMessage($emp->lineUserId, $textMessageBuilder);
            }
        }
        foreach ($linePart as $part) {
            if ($part->store_id == $userStore) {
                $textMessageBuilder = new TextMessageBuilder("新規の掲示が登録されました。\n確認をお願いします");
                $response = $bot->pushMessage($emp->lineUserId, $textMessageBuilder);
                $textMessageBuilder = new TextMessageBuilder("掲示名：" . $inputShareContent . "\n掲示内容：" . $inputText . "\n\n登録者：" . $emp->name);
                $response = $bot->pushMessage($emp->lineUserId, $textMessageBuilder);
            }
        }
        $information = InformationShare::where('store_id', '=', $userStore)->get();
        return view('informationShare', compact('information'));
    }


    public function informationDelete(Request $request)
    {
        $getDeleteId = $request->input('delete');
        $information = InformationShare::where('shareId', '=', $getDeleteId)->delete();
        $user = Auth::user();
        $userStore = $user->store_id;
        $information = InformationShare::where('store_id', '=', $userStore)->get();
        return view('informationShare', compact('information'));
    }
}
