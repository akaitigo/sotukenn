@include('emp_header')
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Calendar</title>
    <link rel="stylesheet" href="/css/shift_add.css" type="text/css">
    <link rel="stylesheet" href="/css/emp_box.css" type="text/css">
    <meta name="description" content="Calendar">
    <meta name="author" content="Charles Anderson">
</head>
<?php
    //ログインしてる人のシフト 全て
    $month = $now_month;
    $year=$now_year;
    $count = 0 ;
    foreach($privatestaffshift as $prv_shift){
        // 月の最大日数でループ
        for($i = 1; $i <= $last_data; $i++){
            $nowday = 'day' . $i;
            $today_shift = $prv_shift->$nowday;
            if($today_shift != -1){
                (int)$num1 = strpos($prv_shift->$nowday,"-");//出勤、退勤抜き出しに使用
                (double)$in =  (double) substr($prv_shift->$nowday,0,$num1);//提出シフトの出勤時間抜き出し
                (double)$out =  (double) substr($prv_shift->$nowday,$num1 + 1);//提出シフトの退勤時間抜き出し
                $start[] = $in;
                $end[] = $out;
                $day[] = $i;   
                $count +=1; 
            }
        }  
    }
    $json_start = json_encode($start);
    $json_end = json_encode($end);
    $json_day = json_encode($day);
?>

<body onload="data_set({{$json_start}},{{$json_end}},{{$json_day}},{{$month}},{{$year}},{{$count}})">
    <div class="emp_box2">
        <div class="content">
            <div class="calendar-container">
                <div class="calendar">
                    <div class="year-header">
                        <span class="left-button" id="prev"> &lang; </span>
                        <span class="year" id="label"></span>
                        <span class="right-button" id="next"> &rang; </span>
                    </div>
                    <table class="months-table">
                        <tbody>
                            <tr class="months-row">
                                <td class="month">1月</td>
                                <td class="month">2月</td>
                                <td class="month">3月</td>
                                <td class="month">4月</td>
                                <td class="month">5月</td>
                                <td class="month">6月</td>
                                <td class="month">7月</td>
                                <td class="month">8月</td>
                                <td class="month">9月</td>
                                <td class="month">10月</td>
                                <td class="month">11月</td>
                                <td class="month">12月</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="days-table">
                        <td class="day">土</td>
                        <td class="day">月</td>
                        <td class="day">火</td>
                        <td class="day">水</td>
                        <td class="day">木</td>
                        <td class="day">金</td>
                        <td class="day">日</td>
                    </table>
                    <div class="frame">
                        <table class="dates-table">
                            <tbody class="tbody">
                            </tbody>
                        </table>
                    </div>
                    <button class="button" id="add-button">登録・更新</button>
                    <button class="button" id="delete-button">予定の削除</button>
                    <button class="button" id="comment-button">コメント</button>
                </div>
            </div>
            {{-- <form action="{{route('emp')}}" method="post"> --}}
            <form action="title" method="post">
                @csrf
                <div class="events-container">
                </div>
                <button type='submit' class="button" id="add-button">送信</button>
            </form>
            <div class="dialog" id="dialog">
                <h2 class="dialog-header">シフト予定を入力してね</h2>
                <form class="form" id="form">
                    <div class="form-container" align="center">
                        <label class="form-label" id="valueFromMyButton" for="name">希望開始時間</label>
                        <input class="input" type="number" id="start" min="0" max="24"
                            maxlength="5">
                        <label class="form-label" id="valueFromMyButton" for="count">希望終了時間</label>
                        <input class="input" type="number" id="end" min="0" max="24"
                            maxlength="5">
                        <datalist id="data-list">
                            {{-- お気に入り --}}
                        </datalist>
                        {{-- <label class="form-label" id="valueFromMyButton" for="count">希望終了時間</label>
                            <input class="input" type="time" id="count" min="0" max="24"
                                maxlength="7"> --}}
                        <input type="button" value="Cancel" class="button" id="cancel-button">
                        <input type="button" value="OK" class="button" id="ok-button">
                    </div>
                </form>
            </div>
            <div class="dialog" id="dialog2">
                <h2 class="dialog-header">シフト予定を入力してね</h2>
                <form class="form" id="form">
                    <div class="form-container" align="center">
                        <label class="form-label" id="valueFromMyButton" for="count">コメント</label>
                        <input class="input" type="text" id="comment" maxlength="8">
                        <datalist id="data-list">
                            {{-- お気に入り --}}
                        </datalist>
                        <input type="button" value="Cancel" class="button" id="cancel-button2">
                        <input type="button" value="OK" class="button" id="ok-button2">
                    </div>
                </form>
            </div>
        </div>

</body>

</html>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

{{-- <script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<link type="text/css" rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

{{-- <script async src="https://code.jquery.com/jquery-3.6.3.js"
    integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> --}}
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
{{-- <script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.core.min.js"></script>
<script type="text/javascript" src="/js/shift_add.js"></script>
