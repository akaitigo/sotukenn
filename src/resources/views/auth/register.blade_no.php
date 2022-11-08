<link rel="stylesheet" href="/css/admin_create.css" type="text/css">
<header >
    <div class="blandWrapper">
        <a class="brand">MARUOKUN</a>
    </div>
</header>
    <div class="root">
        <a href="#" class="rootback">ログイン</a>
        <a class="rootsymbol"><</a>
        <a  class="root_location">タイトル(仮)</a>
    </div>
    <img src="{{ asset('img_submit/submit.png') }}" class="img_create">
    <div class="formbox">
      <form method="POST" action="{{ route('register') }}">
        
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

          <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                </button>
            </div>
        </div>
      </form>          
    </div>
