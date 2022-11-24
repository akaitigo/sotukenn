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
    private $formItems = ["name", "email", "enterprise","password"];

	private $validator = [
		"name" => "required|string|max:100",
		"email" => "required|string|email|max:255|unique:users",
		"password" => "required|string|min:8",
	];
	//フォーム入力画面の表示
	function show(){
		return view("register");
	}
	//POSTの処理
	function post(Request $request){
		
		$data = $request->only($this->formItems);		
		$validator = Validator::make($data, $this->validator);

		if($validator->fails()){
			return redirect()->action("App\Http\Controllers\RegisterFormController@show")
				->withInput()
				->withErrors($validator);
		}

		//セッションに保存
		$request->session()->put("register_input", $data);

		return redirect()->action("App\Http\Controllers\RegisterFormController@confirm");
	}
	//確認画面の表示とセッションの受け取り
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
	//確認画面→登録or戻る時の処理
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
	//完了画面の表示
    function complete(){	
		return view("register_complete");
	}
}
