<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Models\Employee;
use App\Models\Parttimer;

class MessageController extends Controller
{


    public function show(Request $request)
    {
        $messages = Message::where('line_user_id', $request->lineUserId)->get();
        return view('message.show', ['lineUserId' => $request->lineUserId, 'messages' => $messages]);
    }
    public function index1(Request $request)
    {
        $lineUsers = Message::groupBy('line_user_id')->get('line_user_id');
        return view('message.index1', ['lineUsers' => $lineUsers]);
    }

    //通知コントローラー
    public function create(Request $request)
    {
        Message::create([
            'line_user_id' => $request->lineUserId,
            'text' => $request->message,
        ]);

        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);

        $textMessageBuilder = new TextMessageBuilder('シフトを提出して下さい');
        $response = $bot->pushMessage($request->lineUserId, $textMessageBuilder);
        //return redirect(route('message.show', ['lineUserId' => $request->lineUserId]));
    }
}
