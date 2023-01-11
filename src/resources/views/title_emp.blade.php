<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="ホームページサンプル株式会社のサイトです">
    <title>ホームページサンプル株式会社 | ホームページサンプル株式会社のサイトです</title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="stylesheet" href="/css/title_emp.css" type="text/css">
    <link rel="stylesheet" href="/css/title_emp2.css" type="text/css">
    <script type="text/javascript" src="/js/jquery1.4.4.min.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
    <link rel="stylesheet" href="/css/title_loading.css" type="text/css">
</head>

<body>
    <div class="loader-bg js-loader-bg">
        <div class="loader js-loader">
            @include('loading')
        </div>
    </div>
    <header id="header" role="banner">
        <div class="inner">
            <div class="logo">
                <a href="index.html" title="ホームページサンプル株式会社" rel="home">MARUO
                    KUN<br /><span>自動シフト作成アプリ</span></a>
            </div>
            <nav id="mainNav">
                <div class="inner">
                    <a class="menu" id="menu"><span>MENU</span></a>
                    <div class="panel">
                        <ul id="topnav">
                            <li class="current-menu-item"><a
                                    href="index.html"><strong>トップページ</strong><br /><span>Top</span></a></li>
                            <li><a href="sample.html"><strong>LINE追加</strong><br /><span>Greeting</span></a>
                            <li><a href="sample.html"><strong>お問い合わせ</strong><br /><span>Contact</span></a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div class="person1">
        <div class="person">
            <div class="container">
                <div class="container-inner">
                    <img class="circle1" src="/img_submit/sample3.jpg" />
                    <img class="img img1" src="/img_submit/emp.png">
                    <a href="{{ route('employee.login') }}" class="Link"></a>
                </div>
            </div>
            <div class="divider"></div>
            <div class="title">会社員はこちら</div>
        </div>
        <div class="person">
            <div class="container">
                <div class="container-inner">
                    <img class="circle1" src="/img_submit/sample1.jpg" />
                    <img class="img img2" src="/img_submit/part.png">
                    <a href="{{ route('parttimer.login') }}" class="Link"></a>
                </div>
            </div>
            <div class="divider"></div>
            <div class="title">アルバイトはこちら</div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.ui.min.js"></script>
    <script type="text/javascript" src="b.js"></script>

    <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
    <script type="text/javascript" src="a.js"></script>

    <script type="text/javascript" src="/js/loading.js"></script>
    <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>
    <script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
</body>

</html>
