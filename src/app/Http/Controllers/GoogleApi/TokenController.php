<?php

namespace App\Http\Controllers\GoogleApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\GoogleApi\ClientController;
use Google;
use App\Models\Store;

use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    
    public function test(){
        $refreshToken = "1//0e1D02SG70Rw5CgYIARAAGA4SNgF-L9IrDgm7P2lA8qL_kGa3XnhGakHjAmCmLODel0mfc01-B55fArbnnHKcA7CJdKCBPqGxJQ";
        $accessToken = "ya29.a0AeTM1ifMuFoboe6liFG6GmXNwjSoJkvTgljqO-N6H_dPskgcPZk_qmF_9KmOMrc5x5NKnrYZmSjYBwQTHRsHFYRxev9J2vgWKeo73gl6LVCGpMnssqCGODkuOb-BitqmHiqc4EM2to1qVRskvuQWndJgli40aCgYKATUSARMSFQHWtWOmrgCwPWXBrBcacS26cHXp8Q0163";
        $ary = $this->updateAccessToken($refreshToken);
        echo $ary['access_token'];
        dump($this->accessTokenCheck($ary['access_token']));
        dump(Auth::guard('admin')->user());
        dump(Auth::guard('admin')->user()->store());
    }
    public function accessTokenCheck($accessToken){
        //有効期限をチェックし切れてたらfalse,切れてなければtrue
        $controller = new ClientController();
        $client = $controller->makeClient();
        $client->setAccessToken($accessToken);
        
        dump ($client);
        dump($client->isAccessTokenExpired());
        if($client->isAccessTokenExpired()){
            return false;
        }
        return true;
    }
    public function updateAccessToken($refreshToken){
        $controller = new ClientController();
        $client = $controller->makeClient();
        $ary = $client->fetchAccessTokenWithRefreshToken($refreshToken);
        dump($ary);
        return $ary;
    }
    public function saveRefreshToken(Request $request){
        $code = $request->code;
        $clientId=config('services.google.client_id');
        $clientSecret=config('services.google.client_secret');
        $redirectUri="http://localhost:8080/api/callbuck";

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
        $accessToken=$result->access_token;
        $refreshToken=$result->refresh_token;
        if(Auth::guard('admin')->check()){
            $user = Auth::guard('admin')->user();
            $user->fill(['refresh_token'=>$refreshToken,
                         'access_token'=>$accessToken])->save();
            $stores = Store::find($user->store_id);
            return redirect('/submittedShiftEdit');
            // return view('submittedShiftEdit',compact('stores'));
        }else if(Auth::guard('employee')->check()){

        }else if(Auth::guard('parttimer')->check()){

        }
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://www.googleapis.com/oauth2/v4/token',
        //     CURLOPT_POST => true,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_POSTFIELDS => http_build_query([
        //         'refresh_token'=> '1//0esvZClFGxCfcCgYIARAAGA4SNgF-L9Ird-Ug_HxXtKe77ynmPjWIGV7UUNwZlFkSfxlL2hLLcdmQnbyLUsVuujDwNdX_OdagXA',
        //         'client_id' => $clientId,
        //         'client_secret' => $clientSecret,
        //         'redirect_uri' => $redirectUri,
        //         'grant_type' => 'refresh_token',
        //         'access_type' => 'offline'
        //     ]),
        // ));
        // $response = curl_exec($curl);
        // curl_close($curl);
        // $result= json_decode($response);
        // dump($result);
    }
}
