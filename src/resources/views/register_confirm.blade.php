@extends('layouts.app')

@section('content')
    <div class="root">
        <a href="#" class="rootback">ホーム</a>
        <a class="rootsymbol">＜</a>
        <a class="root_location">登録</a>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('確認') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.send') }}">
                            @csrf
                            <!-- 氏名確認フォーム -->
                            <div class="inputWithIcon">
                                <label>名前:</label>{{ $data['name'] }}
							</div>
							<!-- メール確認フォーム -->
                            <div class="inputWithIcon">
                                <label>メールアドレス:</label>{{ $data['email'] }}
							</div>
							<!-- 企業名確認フォーム -->
                            <div class="inputWithIcon">
                                <label>企業名:</label>{{ $data['enterprise'] }}
							</div>
							<!-- パスワード確認フォーム -->
                            <div class="inputWithIcon">
                                <label>パスワード:</label>{{ $data['password'] }}
							</div>

                            <input name="back" type="submit" value="戻る" />
                            <input type="submit" value="送信" />
                        </form>
					</div>
                </div>
            </div>
        </div>
    </div>
@endsection
