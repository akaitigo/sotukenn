<link rel="stylesheet" href="/css/new_header.css" type="text/css">

<?php
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
?>
<div class="new_header">
    <a class="brand">M&nbsp;A&nbsp;R&nbsp;U&nbsp;O&nbsp;K&nbsp;U&nbsp;N</a>
    @include('setting')
</div>
<script>
function savesession() {
    if (document.getElementById("openSidebarMenu").checked){
        window.sessionStorage.setItem('checked','true');
    }else{
        window.sessionStorage.setItem('checked','false');
    }

}
</script>
<input type="checkbox" onclick="savesession()" class="openSidebarMenu" id="openSidebarMenu">
<script>
    if(window.sessionStorage.getItem('checked')=="true"){
    document.getElementById("openSidebarMenu").setAttribute("checked","checked");
    }
</script>
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
                    $role="admin";
                    echo Store::where('id', $storeid)->value('store_name');
                    ?>
                @elseif(Auth::guard('employee')->check())
                    <?php $empid = Auth::guard('employee')->id();
                    $role="employee";
                    echo Employee::where('id', $empid)->value('name');
                    ?>
                @elseif(Auth::guard('parttimer')->check())
                    <?php $partid = Auth::guard('parttimer')->id();
                    $role="parttimer";
                    echo Parttimer::where('id', $partid)->value('name');
                    ?>
                @endif
                <span>ログアウト</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        @if($role=="admin")
        <a href="{{ route('calendar') }}"><li>カレンダー</li></a>
        <a href="{{ route('employeesManagementPassView') }}"><li>従業員管理</li></a>
        <a href="{{ route('noticeManagement') }}"><li>通知管理</li></a>
        <a href="{{ route('submittedShift') }}"><li>提出シフト管理</li></a>
        <a href="{{ route('recruitment_Shift') }}"><li>募集シフト</li></a>
        <a href="{{ route('new_shiftView') }}"><li>シフト閲覧</li></a>
        <a href="{{ route('shiftEdit') }}"><li>シフト編集</li></a>
        <a href="{{ route('informationShare') }}"><li>情報共有</li></a>
        @elseif($role=="employee")
        <a href="{{ route('calendar') }}"><li>カレンダー</li></a>
        <a href="{{ route('employeesManagementPassView') }}"><li>従業員管理</li></a>
        <a href="{{ route('new_shiftView') }}"><li>シフト閲覧</li></a>
        <a href="{{ route('informationShare') }}"><li>情報共有</li></a>
        <a href="{{ route('emp_calendar_show') }}"><li>バイト用ページへ</li></a>
        @endif
    </ul>
</div>
<div>

</div>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>
