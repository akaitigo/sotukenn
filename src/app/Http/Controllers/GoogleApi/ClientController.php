<?php

namespace App\Http\Controllers\GoogleApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google;
use Google_Service_Calendar;

class ClientController extends Controller
{
    public function makeClient(){
        $client = new Google\Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        return $client;
    }
}
