<link rel="stylesheet" href="/css/new_header.css" type="text/css">

<?php
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
?>
<div class="header">
    <a class="brand">M&nbsp;A&nbsp;R&nbsp;U&nbsp;O&nbsp;K&nbsp;U&nbsp;N</a>
    @include('setting')
</div>
<input type="checkbox" checked="checked" class="openSidebarMenu" id="openSidebarMenu">
<label for="openSidebarMenu" class="sidebarIconToggle">
    <div class="spinner diagonal part-1"></div>
    <div class="spinner horizontal"></div>
    <div class="spinner diagonal part-2"></div>
</label>
<div id="sidebarMenu">
    <ul class="sidebarMenuInner">
        <li><a herf="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

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
                <span>ログアウト</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        <li><a href="{{ route('calendar') }}">カレンダー</a></li>
        <li><a href="{{ route('employeesManagementPassView') }}">従業員管理</a></li>
        <li><a href="{{ route('noticeManagement') }}">通知管理</a></li>
        <li><a href="{{ route('submittedShift') }}">提出シフト管理</a></li>
        <li><a href="#">シフト操作</a></li>
        <li><a href="{{ route('informationShare') }}">情報共有</a></li>
    </ul>
</div>
<div>

</div>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
