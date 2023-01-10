<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Models\Message;
use App\Models\Employee;
use App\Models\Parttimer;

use function PHPUnit\Framework\isEmpty;

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

            if ($inputText === "シフト確認") {
                $text = "未実装です";
                $response = $bot->replyText($event['replyToken'], $text);
                break;
            } else if ($inputText === "シフト提出") {
                $text = "未実装です";
                $response = $bot->replyText($event['replyToken'], $text);
                break;
            } else if ($inputText === "ヘルプ") {
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('シフト確認：次回のシフトを確認することができます');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('シフト提出：シフトをLINEで提出をすることができます');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ヘルプ：LINE上で使用できるコマンドをその説明を確認することができます');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('情報共有：業務に関連する情報を共有することができます');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('アカウント連携：MARUOKUNで登録されているアカウントとLINEアカウントを連携します');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                break;
            } else if ($inputText === 'アカウント連携') {
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('MARUOKUNアカウントとLINEアカウントの連携ですね！');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('MARUOKUNで登録しているメールアドレスを送信して下さい！');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                break;
            } else if ($inputText === '情報共有') {
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                $empNullBool = false;
                $partNullBool = false;
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('情報共有ですね！情報共有では、従業員各位に情報を共有することが可能です。');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("※注意：MARUOKUNに表示される期間は最大15日間です。\n通知は一度しか行われません。他者を不快にさせるような通知は行わないようお願いいたします。\n本通知は管理者が確認することができます。");
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('下記のリンクより登録、参照を行うことができます。');
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(route('informationShare'));
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                break;
            } else if (strpos($inputText, 'NOTICE') !== false) { //情報共有




            } else if (strpos($inputText, '@') !== false) { //メールアドレスか検査
                $forcheck = true;
                $employeeNullCheck = Employee::where('email', '=', $inputText)->get();
                $partNullCheck = Parttimer::where('email', '=', $inputText)->get();

                foreach ($employeeNullCheck as $emp) {
                    if ($emp->lineRegister === 1) {
                        if ($emp->email === $inputText) {
                            $forcheck = false;
                            $emp->lineUserId = $event['source']['userId'];
                            $emp->lineRegister = 2;
                            $emp->save();

                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('アカウント情報が確認できました', $emp->name, '様でお間違いなければ下記のリンクよりログインをお願いいたします');
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(route('login.check', ['lineUserId' => $event['source']['userId']]));
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            break;
                        } else {
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('よく確認して');
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            break;
                        }
                    } else {
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('既に登録されています');
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        $forcheck = false;
                        break;
                    }
                }

                foreach ($partNullCheck as $part) {
                    if ($part->lineRegister === 1) {
                        if ($part->email == $inputText) {
                            $forcheck = false;
                            $part->lineUserId = $event['source']['userId'];
                            $part->lineRegister = 2;
                            $part->save();
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('アカウント情報が確認できました', $part->name, '様でお間違いなければ下記のリンクよりログインをお願いいたします');
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(route('login.check', ['lineUserId' => $event['source']['userId']]));
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            break;
                        } else {
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('よく情報を確認してください');
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            break;
                        }
                    } else {
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('既に登録されています');
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        $forcheck = false;
                        break;
                    }
                }
                if ($forcheck) {
                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('アカウントが確認できませんでした。いま一度情報の確認をお願いいたします。');
                    $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                    break;
                }
            } else {
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("コマンドが確認できませんでした。");
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("ヘルプと送信したら利用できるコマンドを確認することができます。\nスマホでご利用の方は、下部のメニューから操作をお願いします");
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
            } //アカウントの連携

        }
    }
}
