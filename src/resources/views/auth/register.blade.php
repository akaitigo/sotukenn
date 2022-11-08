@extends('layouts.app')

@section('content')
<div class="root">
    <a href="#" class="rootback">ログイン</a>
    <a class="rootsymbol"><</a>
    <a  class="root_location">登録</a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員登録') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="inputWithIcon">
                                <input id="name"placeholder="   氏名" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="inputWithIcon">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __(' ') }}</label>

                            
                                <input id="email" type="email" placeholder="   メールアドレス" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="inputWithIcon">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __(' ') }}</label>

                            
                                <input id="password" type="password" placeholder="   パスワード" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="inputWithIcon">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __(' ') }}</label>

                            
                                <input id="password-confirm" type="password" placeholder="   パスワード確認" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
