<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PDF</title>
<style>
body {
  font-family: ipag, serif !important;
  font-size: 9px;
}
th{
}
td{

}
</style>
</head>
<body>
    <h3>{{$year}}年{{$month}}月シフト</h3>
    <table align="center" border="1">
        <?php $keys = array_keys($allshift[0]);?>
        <tr>
            @for($i=0;$i<count($arr);$i++)
            <th style="width:25%">{{$arr[$i]}}</th>
            @endfor
        </tr>
        <tr>
        @foreach($allshift as $shift) 
        <tr>
            @for($j=0;$j<count($keys);$j++)
                <td style="width:25%">{{ $shift[$keys[$j]] }}</td>
            @endfor
        </tr>
        @endforeach
    </table>
</div>
</body>
</html>