@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ isset($authgroup) ? ucwords($authgroup) : ""}} {{ __('Login') }}</div>

                    <div class="card-body">
                        @if($authgroup=='admin')
                        <form method="POST" action="{{ url("admin/login") }}">
                        @elseif($authgroup=='employee')
                        <form method="POST" action="{{ url("employee/login") }}">
                        @else
                        <form method="POST" action="{{ url("parttimer/login") }}">
                        @endif

                            @csrf
                            <div class=form_input>
                                {{-- <div class="inputWithIcon">
                                    <div class="col-md">
                                        <input id="enterprise" type="text" placeholder=" 企業名"
                                            class="form-control @error('enterprise') is-invalid @enderror" name="enterprise"
                                            value="{{ old('enterprise') }}" required autocomplete="enterprise" autofocus>

                                        @error('enterprise')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="inputWithIcon">
                                    <div class="col-md">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>
                                        <input id="email" type="email" placeholder="メールアドレス"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="inputWithIcon">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>

                                    <div class="col-md">
                                        <input id="password" type="password" placeholder="パスワード"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class=passwrod_Forgot>
                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-10">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>

                                        @if (Route::has(isset($authgroup) ? $authgroup.'.password.request' : 'password.request'))
                                            <a class="btn btn-link" href="{{ route(isset($authgroup) ? $authgroup.'.password.request' : 'parttimer.password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
