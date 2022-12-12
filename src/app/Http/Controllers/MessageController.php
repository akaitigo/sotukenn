<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Models\Employee;
use App\Models\Parttimer;
use Illuminate\Database\Console\DumpCommand;
use App\Models\Notice;
use Illuminate\Support\Facades\Hash;

class MessageController extends Controller
{


    public function show(Request $request)
    {
        $notice = Notice::all();
        $getId = $request->noticeId;
        $empPick = Employee::where('id', '=', $getId)->get();
        $partPick = null;



        foreach ($empPick as $emp) {
            $lineId = $emp->lineUserId;
        }


        return view('message.show', compact('lineId', 'empPick', 'notice', 'partPick'));
    }

    public function partShow(Request $request)
    {
        $notice = Notice::all();
        $getId = $request->noticeId;
        $partPick = Parttimer::where('id', '=', $getId)->get();
        $empPick = null;

        foreach ($partPick as $part) {
            $lineId = $part->lineUserId;
        }

        return view('message.show', compact('lineId',  'notice', 'partPick', 'empPick'));
    }


    public function index1(Request $request)
    {
        $lineUsers = Message::groupBy('line_user_id')->get('line_user_id');
        return view('message.index1', ['lineUsers' => $lineUsers]);
    }

    //通知コントローラー
    public function create(Request $request)
    {
        // Message::create([
        //     'line_user_id' => $request->lineId,
        //     'text' => $request->message,
        // ]);
        $getId = $request->noticeId;
        $noticePick = Notice::where('id', '=', $getId)->get();
        $text = 'null';
        foreach ($noticePick as $no) {
            $text = $no->message;
        }
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

        $textMessageBuilder = new TextMessageBuilder($text);
        $response = $bot->pushMessage($request->lineUserId, $textMessageBuilder);
        $employees = Employee::all();
        $parttimers = Parttimer::all();
        return view('employeesManagementPassView', compact('employees', 'parttimers'));
    }

    public function login(Request $request)
    {
        $lineId = $request->lineUserId;


        $employee = Employee::where('lineUserId', '=', $lineId)->get();
        $parttimer = Parttimer::where('lineUserId', '=', $lineId)->get();
        return view('lineLoginCheck', compact('employee', 'parttimer'));
    }
    public function loginCheck(Request $request)
    {
        $inputEmail = $request->mail;
        $inputPass = $request->pass;
        $employee = Employee::where('email', '=', $inputEmail)->get();
        $parttimer = Parttimer::where('lineUserId', '=', $inputEmail)->get();
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

        foreach ($employee as $emp) {
            if ($emp->email === $inputEmail) {
                if (Hash::check($inputPass, $emp->password)) {
                    $emp->lineRegister = 3;
                    $emp->save();
                    $text = "認証に成功しました";
                    $textMessageBuilder = new TextMessageBuilder($text);
                    $response = $bot->pushMessage($emp->lineUserId, $textMessageBuilder);
                }
            }
        }
    }
}
