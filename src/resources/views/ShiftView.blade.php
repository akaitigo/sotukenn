<link rel="stylesheet" href="/css/shiftView.css" type="text/css">
@include('header')

<h2>完成シフト</h2>
<div class="shiftcomp_wrapper">
<table class="shiftcomp">
    <thead>
        <th class="thname">&nbsp;名前&nbsp;</th>
        @for($i= 1;$i <= 30; $i++)
            @if($i % 2 == 0)
                <th class="headgusu">{{ $i }} 日</th>
            @else
                <th class="headkisu">{{ $i }} 日</th>
            @endif
        @endfor
    </thead>
    <tbody>
        @for($staffid= 0; $staffid <= 12; $staffid++)
            <tr><td class="nameview">{{$staff[$staffid][0]}}</td>
            @for($day= 1; $day <= 30; $day++)
                @if($day % 2 == 0)
                    <td class="gusu">{{$EndShift[$staffid][$day]}}</td>
                @else
                    <td class="kisu">{{$EndShift[$staffid][$day]}}</td>
                @endif
            @endfor
            </tr>
        @endfor
    </tbody>
</table>
</div>

<br><br>


<h2>工藤くんの完成シフト</h2>
<table class="shiftcomp_kudo">
    <thead>
        <th class="thname">&nbsp;名前&nbsp;</th>
        @for($i= 1;$i <= 30; $i++)
            @if($i % 2 == 0)
                <th class="headgusu">{{ $i }} 日</th>
            @else
                <th class="headkisu">{{ $i }} 日</th>
            @endif
        @endfor
    </thead>
    <tbody>
        <td class="nameview">{{$staff[10][0]}}</td>
        @for($day= 1; $day <= 30; $day++)
            @if($day % 2 == 0)
                <td class="gusu">{{$EndShift[10][$day]}}</td>
            @else
                <td class="kisu">{{$EndShift[10][$day]}}</td>
            @endif
        @endfor
    </tbody>
</table>

<br><br>


<h2>工藤くんの提出シフト</h2>
<table class="shiftsub_kudo">
    <thead>
        <th class="thname">&nbsp;名前&nbsp;</th>
        @for($i= 1;$i <= 30; $i++)
            @if($i % 2 == 0)
                <th class="headgusu">{{ $i }} 日</th>
            @else
                <th class="headkisu">{{ $i }} 日</th>
            @endif
        @endfor
    </thead>
    <tbody>
        <td class="nameview">{{$staff[10][0]}}</td>
        @for($day= 1; $day <= 30; $day++)
            @if($StaffShift[10][$day] == -1)
                <?php $StaffShift[10][$day] = "×"; ?>
            @endif
            @if($day % 2 == 0)
                <td class="gusu">{{$StaffShift[10][$day]}}</td>
            @else
                <th class="kisu">{{$StaffShift[10][$day]}}</th>
            @endif
        @endfor
    </tbody>
</table>

<br><br>


<h2>工藤くんの従業員設定</h2>
<table class="shiftset_kudo" border="2">
    <thead>
        <th>&nbsp;名前&nbsp;</th>
        <th>&nbsp;期待値&nbsp;</th>
        <th>&nbsp;提出率&nbsp;</th>
        <th>&nbsp;年齢&nbsp;</th>
        <th>&nbsp;社会保険&nbsp;</th>
        <th>&nbsp;学生&nbsp;</th>
        <th>&nbsp;既婚&nbsp;</th>
        <th>&nbsp;キー値&nbsp;</th>
        <th>&nbsp;月の最低労働時間&nbsp;</th>
        <th>&nbsp;月の最高労働時間&nbsp;</th>
        <th>&nbsp;週の最低労働時間&nbsp;</th>
        <th>&nbsp;週の最高労働時間&nbsp;</th>
        <th>&nbsp;１日の最低労働時間&nbsp;</th>
        <th>&nbsp;１日の最高労働時間&nbsp;</th>
    </thead>
    <tbody>
        <td>{{$staff[10][0]}}</td>
        @for($staffsetting= 1; $staffsetting <= 14; $staffsetting++)
            @if($staffsetting==3)
            @else
                @if($staff[10][$staffsetting] == -1)
                    <?php $staff[10][$staffsetting] = "なし"; ?>
                @endif
                <td>{{$staff[10][$staffsetting]}}</td>
            @endif
        @endfor
    </tbody>
</table>
<br><br>