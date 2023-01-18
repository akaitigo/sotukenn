<!doctype html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="最新技術と自然との調和を目指す">
    <meta name="viewport" content="width=device-width">
    <title>laravel</title>
    <link rel="stylesheet" media="all" href="css/style.css">
    <link rel="stylesheet" href="/css/emp_header.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="js/script.js"></script>

</head>
<body>

<div id="sidebar">
    <div id="sidebarWrap">
        <h1><img src="/img_submit/emp_logo2.png" width="140" height="30" alt="logo"></h1>
        <nav id="mainnav">
            <p id="menuWrap"><a id="menu"><span id="menuBtn"></span></a></p>
            <div class="panel">
                <ul>
                    <li><a href="{{ route('emp_calendar') }}">カレンダー</a></li>
                    <li><a href="#sec01">使い方</a></li>
                    <li><a href="{{route('shift_show')}}">シフト提出</a></li>
                    <li><a href="">シフト閲覧</a></li>
                    <li><a href="{{ route('emp_informationShare') }}">情報共有掲示板</a></li>
                </ul>
                <ul id="sns">
                    <li><a href="#" target="_blank"><img src="/img_submit/iconTw.png" width="20"
                                height="20" alt="twitter"></a></li>
                    <li><a href="#" target="_blank"><img src="/img_submit/iconInsta.png" width="20"
                                height="20" alt="Instagram"></a></li>

                </ul>
            </div>
        </nav>
    </div>
</div>
<script type="text/javascript" src="/js/emp_header.js"></script>

</body>
</html>
