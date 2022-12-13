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


<h2>提出シフト</h2>
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