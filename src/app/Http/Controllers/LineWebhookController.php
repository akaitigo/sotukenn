<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Models\Message;
use App\Models\Employee;
use App\Models\Parttimer;

class LineWebhookController extends Controller
{
    public function message(Request $request)
    {
        // return 'ok';
        $data = $request->all();
        $events = $data['events'];
        // $text = '入力内容をもう一度ご確認ください';
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
                $text = "未実装です";
                $response = $bot->replyText($event['replyToken'], $text);
            }
            if ($inputText === "シフトの提出") {
                $text = "未実装です";
                $response = $bot->replyText($event['replyToken'], $text);
            }

            if ($inputText === 'アカウントの連携') {
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('MARUOKUNアカウントとLINEアカウントの連携ですね！');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('MARUOKUNで登録しているメールアドレスを送信して下さい！');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
            }
            if (strpos($inputText, '@') !== false) { //メールアドレスか検査
                $forcheck = true;
                $employeeNullCheck = Employee::where('email', '=', $inputText)->get();
                $partNullCheck = Parttimer::where('email', '=', $inputText)->get();

                foreach ($employeeNullCheck as $emp) {
                    if ($emp->lineRegistere === 1) {
                        if ($emp->email == $inputText) {
                            $forcheck = false;
                            $emp->lineUserId = $event['source']['userId'];
                            $emp->lineRegister = 2;
                            $emp->save();

                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('アカウント情報が確認できました', $emp->name, '様でお間違いなければ下記のリンクよりログインをお願いいたします');
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(route('login.check', ['lineUserId' => $event['source']['userId']]));
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        }
                    } else {
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('既に登録されています');
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        $forcheck = false;
                    }
                }
                if ($forcheck) {
                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('アカウントが確認できませんでした。いま一度情報の確認をお願いいたします。');
                    $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                }
            }
        }
    }
}
