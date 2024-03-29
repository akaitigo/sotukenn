<link rel="stylesheet" href="/css/header.css" type="text/css">
<?php

use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
?>
<header>
    <div class="blandWrapper">
        <nav role="navigation" class="nav">
            <ul class="nav-items">
                <a class="brand">M&nbsp;A&nbsp;R&nbsp;U&nbsp;O&nbsp;K&nbsp;U&nbsp;N</a>

                <!-- カレンダー -->
                <li class="nav-item">
                    <a herf="{{ route('calendar') }}" class="nav-link"><span>カレンダー</span></a>
                </li>
                <!-- 従業員管理 -->
                <li class="nav-item">
                    <a href="{{ route('employeesManagementPassNotView') }}" class="nav-link"><span>従業員管理</span></a>
                </li>
                <!-- 通知管理 -->
                <li class="nav-item">
                    <a href="{{ route('noticeManagement') }}" class="nav-link"><span>通知管理</span></a>
                </li>
                <!-- 提出シフト管理 -->
                <li class="nav-item">
                    <a href="{{ route('submittedShift') }}" class="nav-link"><span>提出シフト管理</span></a>
                </li>
                <!-- シフト作成 -->
                <li class="nav-item dropdown">
                    <a class="nav-link"><span>シフト表の操作&nbsp;∇</span></a>
                    <nav class="submenu">
                        <ul class="submenu-items">

                            <li class="submenu-item"><a href="{{ route('shiftCreate') }}" class="submenu-link">自動シフト作成</a></li>
                            <li class="submenu-item"><a href="{{ route('candidacyView') }}" class="submenu-link">候補シフト表示</a></li>
                            <li class="submenu-item">
                                <hr class="submenu-seperator" />
                            </li>
                            <li class="submenu-item"><a href="{{ route('shiftView') }}" class="submenu-link">シフト閲覧</a>
                            </li>
                            <li class="submenu-item"><a href="{{ route('shiftEdit') }}" class="submenu-link">シフト編集</a>
                            </li>
                        </ul>
                    </nav>
                </li>

                <!-- 情報共有 -->
                <li class="nav-item">
                    <a href="{{ route('informationShare') }}" class="nav-link"><span>情報共有</span></a>
                </li>
                <li class="nav-item">
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link"><span>
                            @if (Auth::guard('admin')->check())
                            <?php $adminid = Auth::guard('admin')->id();
                            $storeid = admin::where('id', $adminid)->value('store_id');
                            echo Store::where('id', $storeid)->value('store_name');
                            ?>
                            @elseif(Auth::guard('employee')->check())
                            <?php $empid = Auth::guard('employee')->id();
                            echo Employee::where('id', $empid)->value('name');
                            ?>
                            @elseif(Auth::guard('parttimer')->check())
                            <?php $partid = Auth::guard('parttimer')->id();
                            echo Parttimer::where('id', $partid)->value('name');
                            ?>
                            @endif
                            &nbsp;∇
                        </span></a>
                    <nav class="submenu">
                        <ul class="submenu-items">
                            <li class="submenu-item">
                                <a class="submenu-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    ログアウト
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </nav>
                </li>
                <li class="nav-item">
                    @include('setting')
                </li>
            </ul>
        </nav>
    </div>
</header>
<div id="setting_div" class="">
    <p id="setting"></p>
</div>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
<script type="text/javascript" src="/js/header.js"></script>