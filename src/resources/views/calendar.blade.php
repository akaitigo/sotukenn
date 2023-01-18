<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/notice.js"></script>
<title>カレンダー</title>
@include('new_header')
<div id="scale">
    <div id='container'>
        <div class='widget'>
            <div class="tab-content" href="#tab1">
                <table class="month_table">
                    <caption>{{ $calendarData[0]['month'] }}月</caption>
                </table>
                <div class="scrollbox">
                    <table class="compshift_table">
                        <thead class="thead">
                            <th class="sunday">日</th>
                            <th>月</th>
                            <th>火</th>
                            <th>水</th>
                            <th>木</th>
                            <th>金</th>
                            <th class="saturday">土</th>
                        </thead>
                        @if($guard=="admin")
                        <tbody>
                            <tr>
                                @php($count = 0)
                                @if ($calendarData[0]['day'] > 0)
                                    @for ($i = 0; $i < $calendarData[0]['day']; $i++)
                                        <td class="kisupartrow"></td>
                                        @php($count++)
                                    @endfor
                                @endif
                                @for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++)
                                    @if ($calendarData[$i]['holiday'] != '-')
                                        <td class="holiday">
                                        @else
                                        <td class="gusupartrow">
                                    @endif
                                    {{ $i }}
                                    @if ($calendarData[$i]['holiday'] != '-')
                                        {{ $calendarData[$i]['holiday'] }}
                                    @endif
                                    {{ $calendarData[$i]['memberCount'] }}
                                    </td>
                                    @php($count++)
                                    @if ($count == 7)
                                        @php($count = 0)
                            </tr>
                            <tr>
                                @endif
                                @endfor
                                @for ($i = $count; $i < 7; $i++)
                                    <td class="kisupartrow"></td>
                                @endfor
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            <tr>
                                @php($count = 0)
                                {{-- マス合わせ --}}
                                @if ($calendarData[0]['day'] > 0)
                                    @for ($i = 0; $i < $calendarData[0]['day']; $i++)
                                        <td class="kisupartrow"></td>
                                        @php($count++)
                                    @endfor
                                @endif
                                {{-- 月の日数分繰り返す --}}
                                @for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++)
                                {{-- 背景色を勤務や祝日に合わせて変更 --}}
                                    @if($calendarData[$i]['shift']!='-')
                                        <td class="kisuemprow">
                                    @elseif ($calendarData[$i]['holiday'] != '-')
                                        <td class="holiday">
                                    @else
                                        <td class="gusupartrow">
                                    @endif
                                    {{ $i."日" }}
                                    {{-- 祝日 --}}
                                    @if ($calendarData[$i]['holiday'] != '-')
                                        {{ $calendarData[$i]['holiday']."　" }}
                                    @endif
                                    {{-- 勤務人数 --}}
                                    {{ $calendarData[$i]['memberCount']."人" }}
                                    {{-- 休みか勤務か --}}
                                    @if($calendarData[$i]['shift']!='-')
                                        {{ $calendarData[$i]['shift']."勤務" }}
                                    @else
                                        休み
                                    @endif
                                    </td>
                                    @php($count++)
                                    {{-- 改行 --}}
                                    @if ($count == 7)
                                        @php($count = 0)
                                        </tr>
                                        <tr>
                                    @endif
                                @endfor
                                {{-- マス埋め --}}
                                @for ($i = $count; $i < 7; $i++)
                                    <td class="kisupartrow"></td>
                                @endfor
                            </tr>
                        </tbody>
                        @endif
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
