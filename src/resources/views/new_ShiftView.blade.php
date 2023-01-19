<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/notice.js"></script>
<script type="text/javascript" src="/js/shift_view.js"></script>
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
    <div id='container'>
        <div class="colorbox_flex">
                <div class="colorbox gusuemprow_name">
                </div>
                <div class="colorbox_text">
                    従業員
                </div>
                <div class="colorbox gusupartrow" id="makeImg">
                </div>
                <div class="colorbox_text">
                    アルバイト
                </div>
                @if ($userId != 0)
                <div class="colorbox loginrow_name" id="makeImg">
                </div>
                <div class="colorbox_text">
                    ログイン中
                </div>
                @endif
        </div>

<!-- 今月のシフト -->
        <div class='widget'>
            <div class="tab-content">
                <table class="month_table">
                    <caption>{{$calendarData[0]["month"]}} 月</caption>
                </table>
                <div class="scrollbox">
                    <table class="compshift_table">
                        <thead class="thead">
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            <?php $count=$calendarData[0]['day'];?>
                            @for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++)
                                <?php
                                $timestamp = mktime(0, 0, 0, $calendarData[0]['month'], $i, 2023);
                                $date = date('w', $timestamp);
                                ?>
                                @if($count==0)
                                <th class="sunday">{{ $i }} 日({{ $week[$count] }})</th>
                                @elseif($count==6)
                                <th class="saturday">{{ $i }} 日({{ $week[$count] }})</th>
                                <?php $count=-1;?>
                                @elseif($array[$i]!='-')
                                <th class="holiday">{{ $i }} 日({{ $week[$count] }})</th>
                                @else
                                <th>{{ $i }} 日({{ $week[$count] }})</th>
                                @endif
                                <?php $count++;?>
                                {{-- @if ($i == 9)
                                    <th class="holiday">{{ $i }} 日({{ $week[$date] }})</th>
                                @elseif($date == 6)
                                    <th class="saturday">{{ $i }} 日({{ $week[$date] }})</th>
                                @elseif($date == 0)
                                    <th class="sunday">{{ $i }} 日({{ $week[$date] }})</th>
                                @else
                                    <th>{{ $i }} 日({{ $week[$date] }})</th>
                                @endif --}}
                            @endfor
                            <th class="workday">労働日数</th>
                            <th class="worktime">労働時間</th>
                        </thead>
                        <tbody>
                            <?php
                            $empnameid = 0;
                            $partnameid = 0;
                            $rowcolor = 0;
                            $i = 0;
                            ?>
                            @foreach ($completeshift as $compshift)
                                <tr>
                                <!-- 名前の処理 -->
                                @if($compshift->emppartid == $userId && $compshift->judge == $empjudge)
                                    @if($compshift->judge)
                                        <td class="loginrow_name" id="name">{{$empname[$empnameid]}}</td>
                                        <?php $empnameid++ ?>
                                    @else
                                        <!-- 太線の処理 -->
                                        @if($compshift->emppartid == 1 && $compshift->judge == false)
                                            <td class="loginrow_name_border" id="name">{{$partname[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @else
                                            <td class="loginrow_name" id="name">{{$partname[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @endif
                                    @endif
                                @elseif($rowcolor % 2 == 0)
                                    @if($compshift->judge)
                                        <td class="gusuemprow_name" id="name">{{$empname[$empnameid]}}</td>
                                        <?php $empnameid++ ?>
                                    @else
                                    <!-- 太線の処理 -->
                                        @if($compshift->emppartid == 1 && $compshift->judge == false)
                                            <td class="gusupartrow_name_border" id="name">{{$partname[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @else
                                            <td class="gusupartrow_name" id="name">{{$partname[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @endif
                                    @endif
                                @else
                                    @if($compshift->judge)
                                        <td class="kisuemprow_name" id="name">{{$empname[$empnameid]}}</td>
                                        <?php $empnameid++ ?>
                                    @else
                                        <td class="kisupartrow_name" id="name">{{$partname[$partnameid]}}</td>
                                        <?php $partnameid++ ?>
                                    @endif
                                @endif


                                <!-- １～３１日の処理 -->
                                    @if ($compshift->emppartid == $userId && $compshift->judge == $empjudge)
                                        @for ($day = 1; $day <= $calendarData[0]['lastDay']; $day++)
                                            <?php $hentai = 'day' . $day; ?>
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                <td class="loginrow_border">{{ $compshift->$hentai }}</td>
                                            @else
                                                <td class="loginrow">{{ $compshift->$hentai }}</td>
                                            @endif
                                        @endfor
                                    @elseif($rowcolor % 2 == 0)
                                        @for($day= 1; $day <= $calendarData[0]['lastDay']; $day++)
                                        <?php $hentai="day".$day?>
                                            @if($compshift->judge == false)
                                                <!-- 太線の処理 -->
                                                @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                    <td class="gusupartrow_border">{{$compshift->$hentai}}</td>
                                                @else
                                                    <td class="gusupartrow">{{$compshift->$hentai}}</td>
                                                @endif
                                            @else
                                                <td class="gusuemprow">{{$compshift->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @else
                                        @for($day= 1; $day <= $calendarData[0]['lastDay']; $day++)
                                        <?php $hentai="day".$day?>
                                            @if($compshift->judge == false)
                                                <td class="kisupartrow">{{$compshift->$hentai}}</td>
                                            @else
                                                <td class="kisuemprow">{{$compshift->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @endif


                                    <!-- 労働日数と労働時間 -->
                                    @if ($compshift->emppartid == $userId && $compshift->judge == $empjudge)
                                        <!-- 太線の処理 -->
                                        @if($compshift->emppartid == 1 && $compshift->judge == false)
                                            <td class="loginrow_border">{{ $Staffworkdays[$i] }}</td>
                                            <td class="loginrow_border">{{ $StaffTimes[$i] }}</td>
                                        @else
                                            <td class="loginrow">{{ $Staffworkdays[$i] }}</td>
                                            <td class="loginrow">{{ $StaffTimes[$i] }}</td>
                                        @endif
                                    @elseif($rowcolor % 2 == 0)
                                        @if($compshift->judge == false)
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                <td class="gusupartrow_border">{{ $Staffworkdays[$i] }}</td>
                                                <td class="gusupartrow_border">{{ $StaffTimes[$i] }}</td>
                                            @else
                                                <td class="gusupartrow">{{ $Staffworkdays[$i] }}</td>
                                                <td class="gusupartrow">{{ $StaffTimes[$i] }}</td>
                                            @endif
                                        @else
                                            <td class="gusuemprow">{{ $Staffworkdays[$i] }}</td>
                                            <td class="gusuemprow">{{ $StaffTimes[$i] }}</td>
                                        @endif
                                    @else
                                        @if($compshift->judge == false)
                                            <td class="kisupartrow">{{ $Staffworkdays[$i] }}</td>
                                            <td class="kisupartrow">{{ $StaffTimes[$i] }}</td>
                                        @else
                                            <td class="kisuemprow">{{ $Staffworkdays[$i] }}</td>
                                            <td class="kisuemprow">{{ $StaffTimes[$i] }}</td>
                                        @endif
                                    @endif
                                </tr>
                                <?php $rowcolor++;
                                $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($userId != 0)
                    {{ $staffshiftcover }}
                @endif
        </div>


<!-- 来月のシフト -->
        <div class='widget'>
                <table class="month_table">
                    <caption>{{$calendarDataNext[0]["month"]}} 月</caption>
                </table>
                <div class="scrollbox">
                    <table class="compshift_table">
                        <thead class="thead">
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            <?php $count=$calendarDataNext[0]['day'];?>
                            @for ($i = 1; $i <= $calendarDataNext[0]['lastDay']; $i++)
                                <?php
                                $timestamp = mktime(0, 0, 0, $calendarDataNext[0]['month'], $i, 2023);
                                $date = date('w', $timestamp);
                                ?>
                                @if($count==0)
                                <th class="sunday">{{ $i }} 日({{ $week[$count] }})</th>
                                @elseif($count==6)
                                <th class="saturday">{{ $i }} 日({{ $week[$count] }})</th>
                                <?php $count=-1;?>
                                @elseif($array[$i]!='-')
                                <th class="holiday">{{ $i }} 日({{ $week[$count] }})</th>
                                @else
                                <th>{{ $i }} 日({{ $week[$count] }})</th>
                                @endif
                                <?php $count++;?>
                                {{-- @if ($i == 9)
                                    <th class="holiday">{{ $i }} 日({{ $week[$date] }})</th>
                                @elseif($date == 6)
                                    <th class="saturday">{{ $i }} 日({{ $week[$date] }})</th>
                                @elseif($date == 0)
                                    <th class="sunday">{{ $i }} 日({{ $week[$date] }})</th>
                                @else
                                    <th>{{ $i }} 日({{ $week[$date] }})</th>
                                @endif --}}
                            @endfor
                            <th class="workday">労働日数</th>
                            <th class="worktime">労働時間</th>
                        </thead>
                        <tbody>
                            <?php
                            $empnameid = 0;
                            $partnameid = 0;
                            $rowcolor = 0;
                            $i = 0;
                            ?>
                            @foreach ($completeshiftNext as $compshiftNext)
                                <tr>
                                <!-- 名前の処理 -->
                                @if($compshiftNext->emppartid == $userId && $compshiftNext->judge == $empjudge)
                                    @if($compshiftNext->judge)
                                        <td class="loginrow_name" id="name">{{$empnameNext[$empnameid]}}</td>
                                        <?php $empnameid++ ?>
                                    @else
                                        <!-- 太線の処理 -->
                                        @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                            <td class="loginrow_name_border" id="name">{{$partnameNext[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @else
                                            <td class="loginrow_name" id="name">{{$partnameNext[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @endif
                                    @endif
                                @elseif($rowcolor % 2 == 0)
                                    @if($compshiftNext->judge)
                                        <td class="gusuemprow_name" id="name">{{$empnameNext[$empnameid]}}</td>
                                        <?php $empnameid++ ?>
                                    @else
                                    <!-- 太線の処理 -->
                                        @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                            <td class="gusupartrow_name_border" id="name">{{$partnameNext[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @else
                                            <td class="gusupartrow_name" id="name">{{$partnameNext[$partnameid]}}</td>
                                            <?php $partnameid++ ?>
                                        @endif
                                    @endif
                                @else
                                    @if($compshiftNext->judge)
                                        <td class="kisuemprow_name" id="name">{{$empnameNext[$empnameid]}}</td>
                                        <?php $empnameid++ ?>
                                    @else
                                        <td class="kisupartrow_name" id="name">{{$partnameNext[$partnameid]}}</td>
                                        <?php $partnameid++ ?>
                                    @endif
                                @endif


                                <!-- １～３１日の処理 -->
                                    @if ($compshiftNext->emppartid == $userId && $compshiftNext->judge == $empjudge)
                                        @for ($day = 1; $day <= $calendarDataNext[0]['lastDay']; $day++)
                                            <?php $hentai = 'day' . $day; ?>
                                            <!-- 太線の処理 -->
                                            @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                                <td class="loginrow_border">{{ $compshiftNext->$hentai }}</td>
                                            @else
                                                <td class="loginrow">{{ $compshiftNext->$hentai }}</td>
                                            @endif
                                        @endfor
                                    @elseif($rowcolor % 2 == 0)
                                        @for($day= 1; $day <= $calendarDataNext[0]['lastDay']; $day++)
                                        <?php $hentai="day".$day?>
                                            @if($compshiftNext->judge == false)
                                                <!-- 太線の処理 -->
                                                @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                                    <td class="gusupartrow_border">{{$compshiftNext->$hentai}}</td>
                                                @else
                                                    <td class="gusupartrow">{{$compshiftNext->$hentai}}</td>
                                                @endif
                                            @else
                                                <td class="gusuemprow">{{$compshiftNext->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @else
                                        @for($day= 1; $day <= $calendarDataNext[0]['lastDay']; $day++)
                                        <?php $hentai="day".$day?>
                                            @if($compshiftNext->judge == false)
                                                <td class="kisupartrow">{{$compshiftNext->$hentai}}</td>
                                            @else
                                                <td class="kisuemprow">{{$compshiftNext->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @endif


                                    <!-- 労働日数と労働時間 -->
                                    @if ($compshiftNext->emppartid == $userId && $compshiftNext->judge == $empjudge)
                                        <!-- 太線の処理 -->
                                        @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                            <td class="loginrow_border">{{ $StaffworkdaysNext[$i] }}</td>
                                            <td class="loginrow_border">{{ $StaffTimesNext[$i] }}</td>
                                        @else
                                            <td class="loginrow">{{ $StaffworkdaysNext[$i] }}</td>
                                            <td class="loginrow">{{ $StaffTimesNext[$i] }}</td>
                                        @endif
                                    @elseif($rowcolor % 2 == 0)
                                        @if($compshiftNext->judge == false)
                                            <!-- 太線の処理 -->
                                            @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                                <td class="gusupartrow_border">{{ $StaffworkdaysNext[$i] }}</td>
                                                <td class="gusupartrow_border">{{ $StaffTimesNext[$i] }}</td>
                                            @else
                                                <td class="gusupartrow">{{ $StaffworkdaysNext[$i] }}</td>
                                                <td class="gusupartrow">{{ $StaffTimesNext[$i] }}</td>
                                            @endif
                                        @else
                                            <td class="gusuemprow">{{ $StaffworkdaysNext[$i] }}</td>
                                            <td class="gusuemprow">{{ $StaffTimesNext[$i] }}</td>
                                        @endif
                                    @else
                                        @if($compshiftNext->judge == false)
                                            <td class="kisupartrow">{{ $StaffworkdaysNext[$i] }}</td>
                                            <td class="kisupartrow">{{ $StaffTimesNext[$i] }}</td>
                                        @else
                                            <td class="kisuemprow">{{ $StaffworkdaysNext[$i] }}</td>
                                            <td class="kisuemprow">{{ $StaffTimesNext[$i] }}</td>
                                        @endif
                                    @endif
                                </tr>
                                <?php $rowcolor++;
                                $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($userId != 0)
                    {{ $staffshiftcoverNext }}
                @endif
            </div>
        </div>


    </div>
</div>
