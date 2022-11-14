<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;


class RegisterFormController extends Controller
{
	use RegistersUsers;

    private $formItems = ["name", "email", "enterprise","password"];

	private $validator = [
		"name" => "required|string|max:100",
		"email" => "required|string|email|max:255|unique:users",
		"password" => "required|string|min:8",
	];

	function show(){
		return view("register");
	}

	function post(Request $request){
		
		$data = $request->only($this->formItems);
		
		$validator = Validator::make($data, $this->validator);
		if($validator->fails()){
			return redirect()->action("App\Http\Controllers\RegisterFormController@show")
				->withInput()
				->withErrors($validator);
		}

		//セッションに書き込む
		$request->session()->put("register_input", $data);

		return redirect()->action("App\Http\Controllers\RegisterFormController@confirm");
	}
	function confirm(Request $request){
		//セッションから値を取り出す
		$data = $request->session()->get("register_input");
		
		//セッションに値が無い時はフォームに戻る
		if(!$data){
			return redirect()->action("App\Http\Controllers\RegisterFormController@show");
		}
		return view("register_confirm",["data" => $data]);
		return view("register_confirm");
	}

    function send(Request $request){
		//セッションから値を取り出す
		$data = $request->session()->get("register_input");

        //戻るボタンが押された時
		if($request->has("back")){
			return redirect()->action("App\Http\Controllers\RegisterFormController@show")
				->withInput($data);
		}
		
		//セッションに値が無い時はフォームに戻る
		if(!$data){
			return redirect()->action("App\Http\Controllers\RegisterFormController@show");
		}
	
		//データベースに登録
		User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "enterprise" => $data['enterprise'],
            "password" => Hash::make($data['password'])
        ]);

		//セッションを空にする
		$request->session()->forget("register_input");

		return redirect()->action("App\Http\Controllers\RegisterFormController@complete");
	}

    function complete(){	
		return view("register_complete");
	}
}
