<link rel="stylesheet" href="/css/employees_header.css" type="text/css">
<?php
use App\Models\admin;
use App\Models\Store;
use App\Models\Employee;
use App\Models\Parttimer;
?>
<header>
    <div class="blandWrapper">
        <a class="brand">MARUOKUN</a>
        <a class="logout" herf="{{ route('logout') }}"
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
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <div class="tabs">
        <input id="all" type="radio" name="tab_item" checked>
        <label class="tab_item" for="all">シフト提出</label>
        <input id="inspection" type="radio" name="tab_item">
        <label class="tab_item" for="inspection">シフト閲覧</label>


        {{-- 提出 --}}
        <div class="tab_content" id="all_content">

        </div>
        {{-- 閲覧 --}}
        <div class="tab_content" id="inspection_content">

        </div>
    </div>
</header>
