<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\LineBotService as LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineWebhookController extends Controller
{
    public function message(Request $request)
    {
        // return 'ok';
        $data = $request->all();
        $test = 'line連携できてるよ';
        $events = $data['events'];

        $httpClient = new CurlHTTPClient(config('services.line.message.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line.message.channel_secret')]);



        // $request->collect('events')->each(function ($event) use ($bot) {
        //     $bot->replyText($event['replyToken'], $event['message']['text']);
        // });


        foreach ($events as $event) {
            $response = $bot->replyText($event['replyToken'], $test);
        }
        return;
    }
}
