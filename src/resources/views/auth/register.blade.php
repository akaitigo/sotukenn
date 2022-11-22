<link rel="stylesheet" href="/css/admin_create.css" type="text/css">
<header >
    <div class="blandWrapper">
        <a class="brand">MARUOKUN</a>
    </div>
</header>
    {{-- <div class="root">
        <a href="#" class="rootback">ログイン</a>
        <a class="rootsymbol"><</a>
        <a  class="root_location">タイトル(仮)</a>
    </div> --}}
    @if($authgroup=='admin')
        <img src="{{ asset('img_submit/submit.png') }}" class="img_create">
      @elseif($authgroup=='employee')
        <h1>社員登録</h1>
      @else
        <h1>アルバイト登録</h1>
    @endif
    <div class="formbox">
        @if($authgroup=='admin')
        <form method="POST" action="{{ url("admin/register") }}">
        @elseif($authgroup=='employee')
        <form method="POST" action="{{ url("employee/register") }}">
        @else
        <form method="POST" action="{{ url("parttimer/register") }}">
        @endif
        @csrf
        <div class="inputWithIcon">
            <input type="text" placeholder="氏名" id="name" name="name" required autocomplete="name" autofocus>
          </div>
          
          <div class="inputWithIcon">
            <input type="text" placeholder="メールアドレス" id="email" name="email" required autocomplete="email">
            <i class="fa fa-envelope fa-lg fa-fw" aria-hidden="true"></i>
          </div>
          
             
          <div class="inputWithIcon">
            <input type="password" placeholder="パスワード" id="password" name="password" required autocomplete="new-password">
            <i class="fa fa-phone fa-lg fa-fw" aria-hidden="true"></i>
          </div>   
          <div class="inputWithIcon">
            <input type="password" placeholder="パスワード確認" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
            <i class="fa fa-phone fa-lg fa-fw" aria-hidden="true"></i>
          </div>
          @if($authgroup=='admin')
          <div class="inputWithIcon">
            <input type="text" placeholder="店舗名" id="store_name" name="store_name">
            <i class="fa fa-phone fa-lg fa-fw" aria-hidden="true"></i>
          </div>
          @else
          <div class="inputWithIcon">
            <input type="text" placeholder="人力" id="weight" name="weight" >
            <i class="fa fa-phone fa-lg fa-fw" aria-hidden="true"></i>
          </div>
          @endif  

          <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
      </form>          
    </div>
