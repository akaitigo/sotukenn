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

<body>
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
        {{-- 確認終わったら消して良し --}}
        <?php
        use Carbon\Carbon;  
        // 来月の取得
        $data = new Carbon('+1 month');
        $month = $data->month;

        //POST受け取り名前
        $data_name = ['year', 'month', 'day', 'comment', 'kind', 'start', 'end'];
        $test_list = [];
        $test = [];
        $data_list = [];
        $work = [];
        //commentの保存 未定
        
        //31日ループ
        for ($x = 0; $x < 31; $x++) {
            $test = [];
            //データの種類でループ
            for ($i = 0; $i < count($data_name); $i++) {        //取得したmonthとmonth_dataの比較
                if (isset($_POST[$data_name[$i] . strval($x)]) && $_POST['month'. strval($x)] == strval($month) ) {
                    //連想配列を作成+月の絞り込み
                    $test += [$data_name[$i] => $_POST[$data_name[$i] . strval($x)]];
                }
                // dump($data_name[$i].":".$x.":".$test);
            }
            //一旦全ての値を-に設定
            $work[$x] = '-';
            // 多重連想配列の作成
            $test_list[$x] = $test;
            dump($test_list[$x]);
            dump($month);

        }


        
        // if (isset($_POST['year1'])) {
        //     // ソート処理(月＞日：昇順)
        //     $month = array_column($test_list, 'month');
        //     $day = array_column($test_list, 'day');
        //     array_multisort($month, SORT_ASC, $day, SORT_ASC, $test_list);
        //     dump($test_list);
        // } else {
        //     $test = 'なし';
        // }
        
        // 31日ループ
        for ($x = 0; $x < 31; $x++) {
            if (isset($test_list[$x]['day'])) {
                // 値が入ってる配列を格納
                $work[$test_list[$x]['day']] = $test_list[$x]['start'] . '-' . $test_list[$x]['end'];
            }
        }
        dump($work);
        
        //送信の簡易確認
        if (isset($_POST['year1'])) {
            $test1 = '送信確認';
        } else {
            $test1 = 'なし';
        }
        dump($test1);
        ?>

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
