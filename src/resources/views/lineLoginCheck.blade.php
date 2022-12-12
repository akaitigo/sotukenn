<link rel="stylesheet" href="/css/login.css" type="text/css">
<header>
    <div class="brandWrapper">
        <a href="#" class="brand">M&emsp;A&emsp;R&emsp;U&emsp;O&emsp;K&emsp;U&emsp;N</a>
    </div>
</header>

<body>


    @if(!($employee->isEmpty()))

    <form method="post" action="{{route('loginCheck')}}">
        @csrf
        emp
    <div class="loginWrapper">
        <div class="informationArea">
            <p>ⓘ</p>
            <div class="informationMessage">ユーザーIDとパスワードを忘れた方は管理者にお問い合わせください。</div>
        </div>
        <p class="loginPane">LINEユーザー認証</p>
        <label for="mailId">*メールD&emsp;&emsp;</label>

        <input type="text" id="mailId" name="mail" placeholder="Email" size="25">
        <br />
        <br />
        <label for="pass">*パスワード</label>
        <input type="password" id="pass" name="pass" placeholder="パスワード" size="25">
        <br />
        <br />
        @foreach($employee as $emp)
        <button name="employeeeId" value={{$emp->id}} class="loginButton">ログイン</button>
         @endforeach

        </form>



    </div>
</body>

    @endif

    @if(!($parttimer->isEmpty()))
    <body>
        <form method="post" action="{{route('loginCheck')}}">
        @csrf
        part
    <div class="loginWrapper">
        <div class="informationArea">
            <p>ⓘ</p>
            <div class="informationMessage">ユーザーIDとパスワードを忘れた方は管理者にお問い合わせください。</div>
        </div>
        <p class="loginPane">LINEユーザー認証</p>
        <label for="mail">*メールD&emsp;&emsp;</label>

        <input type="text" id="mailId" name="mail" placeholder="Email" size="25">
        <br />
        <br />
        <label for="pass">*パスワード</label>
        <input type="password" id="pass" name="pass" placeholder="パスワード" size="25">
        <br />
        <br />
        @foreach($parttimer as $part)
        <button value={{$part->id}} name="partId" class="loginButton">ログイン</button>
        @endforeach

        </form>



    </div>

    @endif



</body>
