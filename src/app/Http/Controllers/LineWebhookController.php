<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use App\Models\Message;
use App\Models\Employee;
use App\Models\Parttimer;
use App\Models\StaffShift;
use Carbon\Carbon;
use App\Models\CompleteShift;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

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
                //JSONデータを取得
                $jsonAry = json_decode(file_get_contents('php://input'), true);
                //メッセージ取得(配列)
                $message = $jsonAry['events'][0]['message'];
                //返信用トークン
                $replyToken = $jsonAry['events'][0]['replyToken'];
                define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');

                $messageData = [
                    'type' => 'template',
                    'altText' => '確認メッセージ', //PCでこのテンプレートは使用できないため、その場合にこのテキスが表示される
                    'template' => [
                        'type' => 'confirm',
                        'text' => 'どのシフトを確認しますか？', //確認ボタンの上部のメッセージ部分
                        'actions' => [
                            [
                                'type' => 'message',
                                'label' => '>次のシフト', //確認ボタンに表示させたい文字
                                'text' => '>次のシフト', //ボタンを押した際に送信させる文字(ボタンを押したタイミングLINE上に表示)
                            ],
                            [
                                'type' => 'message',
                                'label' => '>すべてのシフト',
                                'text' => '>すべてのシフト',
                            ],
                        ],
                    ],
                ];

                $response = [
                    'replyToken' => $replyToken,
                    'messages' => [
                        $messageData,
                    ],
                ];
                $ch = curl_init('https://api.line.me/v2/bot/message/reply');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charser=UTF-8', 'Authorization:  Bearer ' . TOKEN));
                $result = curl_exec($ch);
                curl_close($ch);
            } else if ($inputText === '>次のシフト') {
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                $now = Carbon::now()->format('d');
                $count = $now;
                $countDays = 0;
                foreach ($employeeNullCheck as $emp) {
                    $userId = $emp->id;
                    $shift = CompleteShift::where('emppartid', '=', $userId)->where('judge', '=', true)->get();
                    foreach ($shift as $shi) {
                        for ($i = 0; $i <= 31; $i++) {
                            $days = $now + $i;
                            $daysTemp = 'day' . $days;
                            if ($shi->$daysTemp === '×') {
                            } else if ($shi->$daysTemp === '-') {
                            } else {
                                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->name . 'さんの次の勤務は' . $shi->month . '月' . $days . '日' . $shi->$daysTemp . "です！\n頑張りましょう！！");
                                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                                break;
                            }
                        }
                    }
                }
                foreach ($partNullCheck as $part) {
                    $userId = $emp->id;
                    $shift = CompleteShift::where('emppartid', '=', $userId)->where('judge', '=', false)->get();
                    foreach ($shift as $shi) {
                        for ($i = 0; $i <= 31; $i++) {
                            $days = $now + $i;
                            $daysTemp = 'day' . $days;
                            if ($shi->$daysTemp === '×') {
                            } else if ($shi->$daysTemp === '-') {
                            } else {
                                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($part->name . 'さんの次の勤務は' . $shi->month . '月' . $days . '日' . $shi->$daysTemp . "です！\n頑張りましょう！！");
                                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                                break;
                            }
                        }
                    }
                }
            } else if ($inputText === '>すべてのシフト') {
                $text = "";
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                foreach ($employeeNullCheck as $emp) {
                    $userId = $emp->id;
                    $shift = CompleteShift::where('emppartid', '=', $userId)->where('judge', '=', true)->get();
                    foreach ($shift as $shi) {
                        for ($i = 0; $i <= 31; $i++) {
                            $daysTemp = 'day' . $i;
                            if (!($i === 0)) {
                                $text = $text . $shi->month . "月" . $i . "日" . $shi->$daysTemp . "\n";
                            }
                        }
                    }

                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->name . "さんの" . $shi->month . "月のシフトは\n" . $text);
                    $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                }
                foreach ($partNullCheck as $part) {
                    $userId = $emp->id;
                    $shift = CompleteShift::where('emppartid', '=', $userId)->where('judge', '=', false)->get();
                    foreach ($shift as $shi) {
                        for ($i = 0; $i <= 31; $i++) {
                            $daysTemp = 'day' . $i;
                            if (!($i === 0)) {
                                $text = $text . $shi->month . "月" . $i . "日" . $shi->$daysTemp . "\n";
                            }
                        }
                    }

                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                    $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                }



            } else if ($inputText === "シフト提出") {
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                $nullDay=0;
                $day=0;
                $now = Carbon::now()->format('m');
                foreach ($employeeNullCheck as $emp) {

                    $userId = $emp->id;
                    $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();

                    $nullCheck=false;//null
                    foreach($shift as $shi){
                        $nullCheck=true;//notnull
                    }

                    if($nullCheck){//notnullの時
                        foreach($shift as $shi){
                        for($i=0;$i<=31;$i++){
                            $daysTemp='day'.$i;
                            if(!($i==0)){
                                if($shi->$daysTemp==='*'){
                                    $day=$i;
                                    break;
                                }
                            }

                        }
                    }
                    }else{//nullの時
                        \DB::table('staffshift')->insert([
                            'emppartid'=>$emp->id,
                            'store_id'=>$emp->store_id,
                            'judge'=>true,
                            'month'=>$now,
                        ]);
                        $day=1;
                    }







                    //お気に入りが登録されているかされてないか判別
                    if (!($emp->favoriteShiftRegister)) { //登録されていない

                        $text = "よく使うシフトをお気に入りとして登録をすることで、シフト提出を簡単に行うことができます！\n登録を行いますか？？";
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        //JSONデータを取得
                        $jsonAry = json_decode(file_get_contents('php://input'), true);
                        //メッセージ取得(配列)
                        $message = $jsonAry['events'][0]['message'];
                        //返信用トークン
                        $replyToken = $jsonAry['events'][0]['replyToken'];
                        define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');

                        $messageData = [
                            'type' => 'template',
                            'altText' => '確認メッセージ', //PCでこのテンプレートは使用できないため、その場合にこのテキスが表示される
                            'template' => [
                                'type' => 'confirm',
                                'text' => 'よく使うシフトを登録しますか？？', //確認ボタンの上部のメッセージ部分
                                'actions' => [
                                    [
                                        'type' => 'message',
                                        'label' => '>登録する', //確認ボタンに表示させたい文字
                                        'text' => '>登録する', //ボタンを押した際に送信させる文字(ボタンを押したタイミングLINE上に表示)
                                    ],
                                    [
                                        'type' => 'message',
                                        'label' => '>登録しない',
                                        'text' => '>登録しない',
                                    ],
                                ],
                            ],
                        ];
                        $response = [
                            'replyToken' => $replyToken,
                            'messages' => [
                                $messageData,
                            ],
                        ];
                        $ch = curl_init('https://api.line.me/v2/bot/message/reply');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charser=UTF-8', 'Authorization:  Bearer ' . TOKEN));
                        $result = curl_exec($ch);
                        curl_close($ch);
                    } else { //登録されている
                        $text = $now."月".$day."日のシフトの提出ですね！";
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);                        //JSONデータを取得



                        //JSONデータを取得
                        $jsonAry = json_decode(file_get_contents('php://input'), true);
                        //メッセージ取得(配列)
                        $message = $jsonAry['events'][0]['message'];
                        //返信用トークン
                        $replyToken = $jsonAry['events'][0]['replyToken'];
                        define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');


                        $http_client = new CurlHTTPClient('58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');
                        $bot = new LINEBot($http_client, ['channelSecret' => 'a14576e5515cdd04d92f4c371275cba8']);
                        $signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
                        $http_request_body = file_get_contents('php://input');
                        $events = $bot->parseEventRequest($http_request_body, $signature);
                        $event = $events[0];
                        $reply_token = $event->getReplyToken();


                        $categories = [
                            '×'.'勤務不可',
                            '△'.$emp->favoriteShhift1,
                            '〇'.$emp->favoriteShhift2
                        ];

                        foreach ($categories as $category) {
                            // 1、表示する文言と押下時に送信するメッセージをセット
                            $message_template_action_builder = new MessageTemplateActionBuilder($category, $category );
                            // 2、1をボタンに組み込む
                            $quick_reply_button_builder = new QuickReplyButtonBuilder($message_template_action_builder);
                            // 3、ボタンを配列に格納する(12個まで)
                            $quick_reply_buttons[] = $quick_reply_button_builder;
                        }
                        $quick_reply_message_builder = new QuickReplyMessageBuilder($quick_reply_buttons);
                        $text_message_builder = new TextMessageBuilder('希望する時間を下の選択肢から選択をしてください'."\n選択肢にない場合は、先頭文字に*を入力しハイフン区切りで送信してください。\n例）*10-15", $quick_reply_message_builder);
                        $bot->replyMessage($reply_token, $text_message_builder);
                        //シフトの提出処理

                        


                    }
                }













                //登録されていない場合登録するかの選択


                //登録する場合は登録、しない場合はテキストで送信

                //バツが-1勤務したい日は10-20などのハイフン区切り






            }else if(strpos($inputText, '△') !== false){
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                $nullDay=0;
                $day=0;
                $now = Carbon::now()->format('m');
                foreach ($employeeNullCheck as $emp) {

                    $userId = $emp->id;
                    $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();
                        foreach($shift as $shi){
                            $registerCheck=false;
                        for($i=0;$i<=31;$i++){ 
                            $daysTemp='day'.$i;
                            if(!($i==0)){
                                if($shi->$daysTemp==='*'){
                                    $day=$i;
                                    $registerCheck=true;
                                    break;
                                }
                            }
                        }
                        if($registerCheck){
                            $shi->$daysTemp=$emp->favoriteShhift1;
                            $shi->timestamps = false;
                            $shi->save();
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->favoriteShhift1."で登録しました。");
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        }else{
                            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("提出が終了しました");
                            $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        }
              
                        $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();
                        for($i=0;$i<=31;$i++){ 
                            $daysTemp='day'.$i;
                            if(!($i==0)){
                                if($shi->$daysTemp==='*'){
                                    $day=$i;
                                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("続けてシフトを登録します！");
                                    $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($shi->month.'月'.$day.'日のシフトを提出してください！');
                                    $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                                                 //JSONデータを取得
                        $jsonAry = json_decode(file_get_contents('php://input'), true);
                        //メッセージ取得(配列)
                        $message = $jsonAry['events'][0]['message'];
                        //返信用トークン
                        $replyToken = $jsonAry['events'][0]['replyToken'];
                        define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');


                        $http_client = new CurlHTTPClient('58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');
                        $bot = new LINEBot($http_client, ['channelSecret' => 'a14576e5515cdd04d92f4c371275cba8']);
                        $signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
                        $http_request_body = file_get_contents('php://input');
                        $events = $bot->parseEventRequest($http_request_body, $signature);
                        $event = $events[0];
                        $reply_token = $event->getReplyToken();


                        $categories = [
                            '×'.'勤務不可',
                            '△'.$emp->favoriteShhift1,
                            '〇'.$emp->favoriteShhift2
                        ];

                        foreach ($categories as $category) {
                            // 1、表示する文言と押下時に送信するメッセージをセット
                            $message_template_action_builder = new MessageTemplateActionBuilder($category, $category );
                            // 2、1をボタンに組み込む
                            $quick_reply_button_builder = new QuickReplyButtonBuilder($message_template_action_builder);
                            // 3、ボタンを配列に格納する(12個まで)
                            $quick_reply_buttons[] = $quick_reply_button_builder;
                        }
                        $quick_reply_message_builder = new QuickReplyMessageBuilder($quick_reply_buttons);
                        $text_message_builder = new TextMessageBuilder('希望する時間を下の選択肢から選択をしてください'."\n選択肢にない場合は、先頭文字に*を入力しハイフン区切りで送信してください。\n例）*10-15", $quick_reply_message_builder);
                        $bot->replyMessage($reply_token, $text_message_builder);
                                    break;
                                }
                            }
                        }
                    }
                }
            
                    
                    



            }else if(strpos($inputText, '〇') !== false){
                    $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                    $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                    $nullDay=0;
                    $day=0;
                    $now = Carbon::now()->format('m');
                    foreach ($employeeNullCheck as $emp) {
    
                        $userId = $emp->id;
                        $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();
    
    
    
                            foreach($shift as $shi){
                                $registerCheck=false;
                            for($i=0;$i<=31;$i++){ 
                                $daysTemp='day'.$i;
                                if(!($i==0)){
                                    if($shi->$daysTemp==='*'){
                                        $day=$i;
                                        $registerCheck=true;
                                        break;
                                    }
                                }
                            }
                            if($registerCheck){
                                $shi->$daysTemp=$emp->favoriteShhift2;
                                $shi->timestamps = false;
                                $shi->save();
                                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->favoriteShhift2."で登録しました。");
                                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            }else{
                                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("提出が終了しました");
                                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            }
                  
                            $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();
                            for($i=0;$i<=31;$i++){ 
                                $daysTemp='day'.$i;
                                if(!($i==0)){
                                    if($shi->$daysTemp==='*'){
                                        $day=$i;
                                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("続けてシフトを登録します！");
                                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($shi->month.'月'.$day.'日のシフトを提出してください！');
                                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                         //JSONデータを取得
                        $jsonAry = json_decode(file_get_contents('php://input'), true);
                        //メッセージ取得(配列)
                        $message = $jsonAry['events'][0]['message'];
                        //返信用トークン
                        $replyToken = $jsonAry['events'][0]['replyToken'];
                        define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');


                        $http_client = new CurlHTTPClient('58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');
                        $bot = new LINEBot($http_client, ['channelSecret' => 'a14576e5515cdd04d92f4c371275cba8']);
                        $signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
                        $http_request_body = file_get_contents('php://input');
                        $events = $bot->parseEventRequest($http_request_body, $signature);
                        $event = $events[0];
                        $reply_token = $event->getReplyToken();


                        $categories = [
                            '×'.'勤務不可',
                            '△'.$emp->favoriteShhift1,
                            '〇'.$emp->favoriteShhift2
                        ];

                        foreach ($categories as $category) {
                            // 1、表示する文言と押下時に送信するメッセージをセット
                            $message_template_action_builder = new MessageTemplateActionBuilder($category, $category );
                            // 2、1をボタンに組み込む
                            $quick_reply_button_builder = new QuickReplyButtonBuilder($message_template_action_builder);
                            // 3、ボタンを配列に格納する(12個まで)
                            $quick_reply_buttons[] = $quick_reply_button_builder;
                        }
                        $quick_reply_message_builder = new QuickReplyMessageBuilder($quick_reply_buttons);
                        $text_message_builder = new TextMessageBuilder('希望する時間を下の選択肢から選択をしてください'."\n選択肢にない場合は、先頭文字に*を入力しハイフン区切りで送信してください。\n例）*10-15", $quick_reply_message_builder);
                        $bot->replyMessage($reply_token, $text_message_builder);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                
                        
                        
    
    
    



                }else if(strpos($inputText, '×') !== false){
                    $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                    $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                    $nullDay=0;
                    $day=0;
                    $now = Carbon::now()->format('m');
                    foreach ($employeeNullCheck as $emp) {
    
                        $userId = $emp->id;
                        $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();
    
    
    
                            foreach($shift as $shi){
                                $registerCheck=false;
                            for($i=0;$i<=31;$i++){ 
                                $daysTemp='day'.$i;
                                if(!($i==0)){
                                    if($shi->$daysTemp==='*'){
                                        $day=$i;
                                        $registerCheck=true;
                                        break;
                                    }
                                }
                            }
                            if($registerCheck){
                                $shi->$daysTemp=$emp->favoriteShhift2;
                                $shi->timestamps = false;
                                $shi->save();
                                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->favoriteShhift2."で登録しました。");
                                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            }else{
                                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("提出が終了しました");
                                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                            }
                  
                            $shift = StaffShift::where('emppartid', '=', $emp->id)->where('judge', '=', true)->get();
                            for($i=0;$i<=31;$i++){ 
                                $daysTemp='day'.$i;
                                if(!($i==0)){
                                    if($shi->$daysTemp==='*'){
                                        $day=$i;
                                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("続けてシフトを登録します！");
                                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($shi->month.'月'.$day.'日のシフトを提出してください！');
                                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                         //JSONデータを取得
                        $jsonAry = json_decode(file_get_contents('php://input'), true);
                        //メッセージ取得(配列)
                        $message = $jsonAry['events'][0]['message'];
                        //返信用トークン
                        $replyToken = $jsonAry['events'][0]['replyToken'];
                        define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');


                        $http_client = new CurlHTTPClient('58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');
                        $bot = new LINEBot($http_client, ['channelSecret' => 'a14576e5515cdd04d92f4c371275cba8']);
                        $signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
                        $http_request_body = file_get_contents('php://input');
                        $events = $bot->parseEventRequest($http_request_body, $signature);
                        $event = $events[0];
                        $reply_token = $event->getReplyToken();


                        $categories = [
                            '×'.'勤務不可',
                            '△'.$emp->favoriteShhift1,
                            '〇'.$emp->favoriteShhift2
                        ];

                        foreach ($categories as $category) {
                            // 1、表示する文言と押下時に送信するメッセージをセット
                            $message_template_action_builder = new MessageTemplateActionBuilder($category, $category );
                            // 2、1をボタンに組み込む
                            $quick_reply_button_builder = new QuickReplyButtonBuilder($message_template_action_builder);
                            // 3、ボタンを配列に格納する(12個まで)
                            $quick_reply_buttons[] = $quick_reply_button_builder;
                        }
                        $quick_reply_message_builder = new QuickReplyMessageBuilder($quick_reply_buttons);
                        $text_message_builder = new TextMessageBuilder('希望する時間を下の選択肢から選択をしてください'."\n選択肢にない場合は、先頭文字に*を入力しハイフン区切りで送信してください。\n例）*10-15", $quick_reply_message_builder);
                        $bot->replyMessage($reply_token, $text_message_builder);
                                        break;
                                    }
                                }
                            }
                        }
                    }
                
                        



            }else if ($inputText === ">登録する") {
                $text = "お気に入りシフトの登録ですね！";
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();

                foreach ($employeeNullCheck as $emp) {

                    //JSONデータを取得
                    $jsonAry = json_decode(file_get_contents('php://input'), true);
                    //メッセージ取得(配列)
                    $message = $jsonAry['events'][0]['message'];
                    //返信用トークン
                    $replyToken = $jsonAry['events'][0]['replyToken'];
                    define('TOKEN', '58lQH4owjr8z/cqqGenWkktXMNmsP7m5l3ymC3lxbsapeEiV8o5vw+awBUm76lBQd0YeDA7UsZcozPR9J1Tp36NksdsCYcLjy1Ilnz0TmWLLB2YOrZUAWGFjO9Hqk1JTgQ59Vzz/WW77cJtINtc1QwdB04t89/1O/w1cDnyilFU=');

                    $messageData = [
                        'type' => 'template',
                        'altText' => '確認メッセージ', //PCでこのテンプレートは使用できないため、その場合にこのテキスが表示される
                        'template' => [
                            'type' => 'confirm',
                            'text' => 'どちらのシフトを登録、変更しますか？', //確認ボタンの上部のメッセージ部分
                            'actions' => [
                                [
                                    'type' => 'message',
                                    'label' => '>①' . $emp->favoriteShhift1, //確認ボタンに表示させたい文字
                                    'text' => '>1', //ボタンを押した際に送信させる文字(ボタンを押したタイミングLINE上に表示)
                                ],
                                [
                                    'type' => 'message',
                                    'label' => '>②' . $emp->favoriteShhift2,
                                    'text' => '>2',
                                ],
                            ],
                        ],
                    ];

                    $response = [
                        'replyToken' => $replyToken,
                        'messages' => [
                            $messageData,
                        ],
                    ];
                    $ch = curl_init('https://api.line.me/v2/bot/message/reply');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charser=UTF-8', 'Authorization:  Bearer ' . TOKEN));
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            } else if ($inputText === '>1') {
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                
                foreach ($employeeNullCheck as $emp) {

                    if ($emp->favoriteShiftRegisterCheck1 === 1) {
                        $text = $inputText . "の" . $emp->favoriteShhift1 . "追加、変更を行います！";
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        $emp->favoriteShiftRegisterCheck1 = 2;
                        $emp->save();
                        $text = $inputText . "に登録したい時間を先頭に#をつけてハイフン区切りで送信して下さい。例）#10-20";
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                    }
                }
            } else if (strpos($inputText, '#') !== false) {
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();

                foreach ($employeeNullCheck as $emp) {
                    if ($emp->favoriteShiftRegisterCheck1 === 2) {
                        $emp->favoriteShiftRegisterCheck1 = 1;
                        $inputTime = substr($inputText, 1,);
                        $emp->favoriteShhift1 = $inputTime;
                        $emp->save();
                        $text = $inputTime;
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->favoriteShhift1);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                    } else if ($emp->favoriteShiftRegisterCheck2 === 2) {
                        $emp->favoriteShiftRegisterCheck2 = 1;
                        $inputTime = substr($inputText, 1,);
                        $emp->favoriteShhift2 = $inputTime;
                        $emp->save();
                        $text = $inputTime;
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($emp->favoriteShhift2);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                    }

                    if ($emp->favoriteShhift1 != '-' && $emp->favoriteShhift2 != '-') {
                        $emp->favoriteShiftRegister = true;
                        $emp->save();
                    }
                }
            } else if ($inputText === ">2") {
                $employeeNullCheck = Employee::where('lineUserId', '=', $event['source']['userId'])->get();
                $partNullCheck = Parttimer::where('lineUserId', '=', $event['source']['userId'])->get();
                foreach ($employeeNullCheck as $emp) {


                    if ($emp->favoriteShiftRegisterCheck2 === 1) {

                        $text = $inputText . "の" . $emp->favoriteShhift2 . "追加、変更を行います！";
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                        $emp->favoriteShiftRegisterCheck2 = 2;
                        $emp->save();
                        $text = $inputText . "に登録したい時間を先頭に#をつけてハイフン区切りで送信して下さい。例）#10-20";
                        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                        $response = $bot->pushMessage($event['source']['userId'], $textMessageBuilder);
                    }
                }
            } else if ($inputText === ">登録しない") {
                //手動でシフト提出処理
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
