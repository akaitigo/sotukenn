<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Models\Message;
use App\Models\Employee;
use App\Models\Parttimer;
use Illuminate\Support\Facades\Hash;

class LineWebhookController extends Controller
{
    public function message(Request $request)
    {
        // return 'ok';
        $data = $request->all();
        $events = $data['events'];
        $text = 'null';
        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);
        foreach ($events as $event) {
            Message::create([
                'line_user_id' => $event['source']['userId'],
                'line_message_id' => $event['message']['id'],
                'text' => $event['message']['text'],
            ]);



            $inputText = $event['message']['text'];
            $inputLineId = $event['source']['userId'];
            if ($inputText === "シフトの確認") {
                //
            } else if ($inputText == "メモ") {
                //
            } else if (strpos($inputText, '@') !== false) {
                $inputMail = substr($inputText, 0, strcspn($inputText, '&'));
                $employeeNullCheck = Employee::where('email', '=', $inputMail)->get();
                $partNullCheck = Parttimer::where('email', '=', $inputMail)->get();
                if (!(is_null($employeeNullCheck))) {
                    foreach ($employeeNullCheck as $emp) {
                        $inputPass = mb_substr($inputText, mb_strrpos($inputText, '&') + 1, mb_strlen($inputText));
                        if (Hash::check($inputPass, $emp->password)) {
                            $emp->lineUserId = $inputLineId;
                            $emp->lineRegister = true;
                            $emp->save();
                            $text = "照合成功";
                        } else {
                            $text = "照合失敗";
                        }
                    }
                }
                if (!(is_null($partNullCheck))) {
                    foreach ($partNullCheck as $part) {
                        $inputPass = mb_substr($inputText, mb_strrpos($inputText, '&') + 1, mb_strlen($inputText));
                        if (Hash::check($inputPass, $part->password)) {
                            $part->lineUserId = $inputLineId;
                            $part->lineRegister = true;
                            $part->save();
                            $text = "照合成功";
                        } else {
                            $text = "照合失敗";
                        }
                    }
                }

                $response = $bot->replyText($event['replyToken'], $text);
            }
            return;
        }
    }
}
