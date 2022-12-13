<?php

namespace App\Http\Controllers\ryu_test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use DateTime;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_AclRule;
use Google_Service_Calendar_AclRuleScope;
use Socialite;

class CalendarApiController extends Controller
{
    public function saveToken(Request $request){
        dump($request);
    }
    public function handleGoogleCallback(Request $request)
    {
        $code = $request->code;
        $clientId=config('services.google.client_id');
        $clientSecret=config('services.google.client_secret');
        $redirectUri="http://localhost:8080/api/index";

        $url = "https://accounts.google.com/o/oauth2/token";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query([
                'code' => $code,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'authorization_code',
                'access_type' => 'offline'
            ]),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result= json_decode($response);
        dump($result);
        // $accessToken=$result->access_token;
        // $refreshToken=$result->refresh_token;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.googleapis.com/oauth2/v4/token',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POSTFIELDS => http_build_query([
                'refresh_token'=> '1//0esvZClFGxCfcCgYIARAAGA4SNgF-L9Ird-Ug_HxXtKe77ynmPjWIGV7UUNwZlFkSfxlL2hLLcdmQnbyLUsVuujDwNdX_OdagXA',
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUri,
                'grant_type' => 'refresh_token',
                'access_type' => 'offline'
            ]),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $result= json_decode($response);
        dump($result);
        // $ch = curl_init(); // はじめ
        // $POST_DATA = array(
        //     'client_id' => $clientId,
        //     'client_secret' => $clientSecret,
        //     'redirect_uri' => $redirectUri,
        //     'grant_type' => 'authorization_code',
        //     'code' => $code
        // );
        // //オプション
        // curl_setopt($ch,CURLOPT_POST, TRUE);
        // curl_setopt($ch, CURLOPT_URL, $url); 
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $info = curl_exec($ch);//この関数で取得
        // curl_close($ch);
        // dump ($info);
    // //    curl -d client_id=************ -d client_secret=*********** -d redirect_uri=************** -d grant_type=authorization_code -d code={さっき取得したcodeパラメーターの値} 
    }

    public function test()
    {
        $client = $this->getClient();
        //カレンダー作成テスト
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $service = new Google_Service_Calendar($client);
        $calendar = new Google_Service_Calendar_Calendar();
        $calendar->setSummary('がんばれ');
        $calendar->setTimeZone('Asia/Tokyo');
        $createdCalendar = $service->calendars->insert($calendar);

        $rule = new Google_Service_Calendar_AclRule();
        $scope = new Google_Service_Calendar_AclRuleScope();
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $service = new Google_Service_Calendar($client);

        $scope->setType("user");
        $scope->setValue("ryusei1116nakayama@gmail.com");
        $rule->setScope($scope);
        $rule->setRole("writer");

        $createdRule = $service->acl->insert($createdCalendar->getId(), $rule);
        dump($createdRule);
        // //カレンダー作成テスト
        // $client->setScopes(Google_Service_Calendar::CALENDAR);
        // $service = new Google_Service_Calendar($client);
        // $calendar = new Google_Service_Calendar_Calendar();
        // $calendar->setSummary('がんばれ');
        // $calendar->setTimeZone('Asia/Tokyo');
        // $createdCalendar = $service->calendars->insert($calendar);
        // echo $createdCalendar->getId();
        // dump($createdCalendar);
        // echo "イベントを追加しました";
        // //インサートテスト
        // $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        // $service = new Google_Service_Calendar($client);
        // $event = new Google_Service_Calendar_Event(array(
        //     //タイトル
        //     'summary' => 'テスト',
        //     'start' => array(
        //         // 開始日時
        //         'dateTime' => '2022-12-05T11:00:00+09:00',
        //         'timeZone' => 'Asia/Tokyo',
        //     ),
        //     'end' => array(
        //         // 終了日時
        //         'dateTime' => '2022-12-05T12:00:00+09:00',
        //         'timeZone' => 'Asia/Tokyo',
        //     ),
        // ));
        // $event = $service->events->insert($calendarId, $event);
        // echo "イベントを追加しました";
        // //deleteテスト
        // // $service->events->delete($calendarId, '27af8m3iggpm92kabnr7bia3on');
        // //selectテスト
        // $start = date(date('Y'). '-12-01\T00:00:00\Z');
        // $end = date(date('Y'). '-12-31\T00:00:00\Z');
        // $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        // $service = new Google_Service_Calendar($client);
        // $option = [
        //     'timeMin' => $start,
        //     'timeMax' => $end,
        //     'orderBy' => 'startTime',
        //     'singleEvents' => 'true'
        // ];
        // $response = $service->events->listEvents($calendarId, $option);
        // $events = $response->getItems();
        // dump($events);
        // $results = [];
        // if (!empty($events)) {
        //     foreach ($events as $event) {
        //         // 終日予定はdate、時刻指定はdateTimeにデータが入り、もう片方にはNULLが入っている
        //         $start = new DateTime(!is_null($event->start->date)?$event->start->date:$event->start->dateTime);
        //         $end   = new DateTime(!is_null($event->end->date)?$event->end->date:$event->end->dateTime);
        //         $results[$start->format('Y-m-d')][] = [
        //             'start' => $start->format('Y-m-d H:i:s'),
        //             'end' => $end->format('Y-m-d H:i:s'),
        //             'title' => (string)$event->summary
        //         ];
        //     }
        // }
        // var_dump($results);
    }
    public function index(){

    }    
    public function redirectToGoogle()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(['https://www.googleapis.com/auth/calendar']);
        $client->setPrompt('consent');
        $client->setAccessType('offline');
        $auth_url = $client->createAuthUrl();
        return redirect($auth_url);

        // $client->get('https://www.googleapis.com/calendar/v3/calendars/' . $calendar_id . '/events');
        // Google へのリダイレクト
        // return Socialite::driver('google')->redirect();
    }
    private function getClient()
    {
        $client = new Google_Client();

        //アプリケーション名
        $client->setApplicationName('GoogleCalendarAPIのテスト');
        //権限の指定
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        //JSONファイルの指定
        $client->setAuthConfig(storage_path('app/api-key/sotuken-calendar-4113a2ab5602.json'));

        return $client;
    }
}
