<link rel="stylesheet" href="/css/titleEmployees.css" type="text/css">
<link rel="stylesheet" href="/css/title_loading.css" type="text/css">
<header>
    <body>
        <div class="loader-bg js-loader-bg">
            <div class="loader js-loader">
                @include('loading')
            </div>
        </div>
        <div class="wrap">
            <div class="content">
                <div class="titleName">
                    <a class="title">M&nbsp;A&nbsp;R&nbsp;U&nbsp;O&nbsp;K&nbsp;U&nbsp;N</a>
                </div>
        
                <div class="ButtonArea">
                    <div class="space">
                        <a href="{{ route('employee.login') }}" class="loginButton">従業員のログインはこちら</a>
                    </div><br />
                    <br />
                    <a href="{{ route('parttimer.login') }}" class="registerButton">アルバイトのログインはこちら</a>
                </div>
            </div>
        </div>
    </body>
</header>

<script type="text/javascript" src="/js/loading.js"></script>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
<script
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
