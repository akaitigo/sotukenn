<!doctype html>
<html lang="ja">
<?php
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
use Carbon\Carbon;
$now = [
            'month'=>Carbon::now()->month,
            'year' =>Carbon::now()->year
        ];
?>
@if (Auth::guard('admin')->check())
<?php $adminid = Auth::guard('admin')->id();
$storeid = admin::where('id', $adminid)->value('store_id');
$role="admin";
?>
@elseif(Auth::guard('employee')->check())
<?php $empid = Auth::guard('employee')->id();
$role="employee";
?>
@elseif(Auth::guard('parttimer')->check())
<?php $partid = Auth::guard('parttimer')->id();
$role="parttimer";
?>
@endif
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
                        <li><a href="{{ route('emp_calendar_show') }}">カレンダー</a></li>
                        <li><a href="{{ route('shift_show') }}">シフト提出・閲覧</a></li>
                        <li><a href="{{ route('emp_informationShare') }}">情報共有掲示板</a></li>
                        <li><a herf="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        @if($role=="employee")
                            <li><a href="{{ route('calendar') }}">管理者ページへ</a></li>
                        @endif
                    </ul>
                    <ul id="sns">
                        <p>・今月シフト</p>
                        <li><a href="{{route('downloadpdf', ['year' => $now['year'], 'month' => $now['month']]) }}" target="_blank"><img src="/img_submit/PDF.png" width="20"
                                    height="20" alt="twitter"></a></li>
                        <li><a href="{{route('downloadimage', ['year' => $now['year'], 'month' => $now['month']]) }}" target="_blank"><img src="/img_submit/Jpeg.png" width="20"
                                    height="20" alt="Instagram"></a></li>
                        <br>
                        <p>・来月シフト</p>
                        @if($now['month']==12)
                        <li><a href="{{ route('downloadpdf', ['year' => $now['year']+1, 'month' => '1']) }}" target="_blank"><img src="/img_submit/PDF.png" width="20"
                                    height="20" alt="twitter"></a></li>
                        <li><a href="{{route('downloadimage', ['year' => $now['year']+1, 'month' => '1']) }}" target="_blank"><img src="/img_submit/Jpeg.png" width="20"
                                    height="20" alt="Instagram"></a></li>
                        @else
                        <li><a href="{{route('downloadpdf', ['year' => $now['year'], 'month' => $now['month']+1]) }}" target="_blank"><img src="/img_submit/PDF.png" width="20"
                                    height="20" alt="twitter"></a></li>
                        <li><a href="{{route('downloadimage', ['year' => $now['year'], 'month' => $now['month']+1]) }}" target="_blank"><img src="/img_submit/Jpeg.png" width="20"
                                    height="20" alt="Instagram"></a></li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <script type="text/javascript" src="/js/emp_header.js"></script>

</body>

</html>
