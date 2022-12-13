@include('header')

<h2>完成シフト</h2>
<table border="2">
    <thead>
        <th>名前</th>
        @for($i= 1;$i <= 30; $i++)
            <th><?php echo $i; ?>日</th>
        @endfor
    </thead>
    <tbody>
        @for($staffid= 0; $staffid <= 12; $staffid++)
            <tr><td>{{$staff[$staffid][0]}}</td>
            @for($day= 1; $day <= 30; $day++)
                <td>{{$EndShift[$staffid][$day]}}</td>
            @endfor
            </tr>
        @endfor
    </tbody>
</table>

<br><br>


<h2>工藤くんの提出シフト</h2>
<table border="2">
    <thead>
        <th>名前</th>
        @for($i= 1;$i <= 30; $i++)
            <th><?php echo $i; ?>日</th>
        @endfor
    </thead>
    <tbody>
        <td>{{$staff[10][0]}}</td>
        @for($day= 1; $day <= 30; $day++)
            <td>{{$StaffShift[10][$day]}}</td>
        @endfor
    </tbody>
</table>

<br><br>


<h2>工藤くんの従業員設定</h2>
<table border="2">
    <thead>
        <th>名前</th>
        <th>期待値</th>
        <th>提出率</th>
        <th>年齢</th>
        <th>社会保険</th>
        <th>学生</th>
        <th>既婚</th>
        <th>キー値</th>
        <th>月の最低労働時間</th>
        <th>月の最高労働時間</th>
        <th>週の最低労働時間</th>
        <th>週の最高労働時間</th>
        <th>１日の最低労働時間</th>
        <th>１日の最高労働時間</th>
    </thead>
    <tbody>
        <td>{{$staff[10][0]}}</td>
        @for($staffsetting= 1; $staffsetting <= 14; $staffsetting++)
        @if($staffsetting==4)
        @else
            <td>{{$staff[10][$staffsetting]}}</td>
        @endif
        @endfor
    </tbody>
</table>
