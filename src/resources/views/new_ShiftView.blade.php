<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/tab.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/shift_edit.css" type="text/css">
<link rel="stylesheet" href="/css/shiftView.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
<?php $nextlastday = $calendarDataNext[0]['lastDay'];?>
    @if($nextcomshiftjudge == 0 && $userId == 0)
         <div class="mom_scopeday" id="mom_scopeday" value="{{$nextcomshiftjudge}}"> 
            <div class="scopeday">
                <input class="startdaypull" type="number" id="startdaypull" min="1" max="{{$nextlastday}}" oninput="shiftpull({{$nextlastday}},{{$shift_divicount}})" step="1"/> 日～
                <input class="enddaypull" type="number" id="enddaypull" min="1" max="{{$nextlastday}}" oninput="shiftpull({{$nextlastday}},{{$shift_divicount}})" step="1"/> 日
            </div>
        </div>
    @endif

    <!-- カラーボックス -->
    <div class="mom" id="mom_colorbox">
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
    </div>
    <div id='container'>
        <?php
        $thismonth = $calendarData[0]["month"] . '月';
        $nextmonth = $calendarDataNext[0]["month"] . '月';
        ?>

        <!-- 今月のシフト -->
        <div class='widget'>
            <div id='{{$thismonth}}' class="tab-content" href="?tab1">
                <table class="month_table">
                    <caption>{{$calendarData[0]["month"]}} 月</caption>
                </table>
                <div class="scrollbox">
                    <table class="compshift_table">
                        <thead class="thead">
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            <?php $count = $calendarData[0]['day']; ?>
                            @for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++) <?php
                                                                                    $timestamp = mktime(0, 0, 0, $calendarData[0]['month'], $i, 2023);
                                                                                    $date = date('w', $timestamp);
                                                                                    ?> 
                                @if($count==0) 
                                    <th class="sunday">{{ $i }} 日({{ $week[$count] }})</th>
                                @elseif($count==6)
                                    <th class="saturday">{{ $i }} 日({{ $week[$count] }})</th>
                                    <?php $count = -1; ?>
                                @elseif($array[$i] != '-')
                                    <th class="holiday">{{ $i }} 日({{ $week[$count] }})</th>
                                @else
                                    <th>{{ $i }} 日({{ $week[$count] }})</th>
                                @endif
                                <?php $count++; ?>

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
                                @for ($day = 1; $day <= $calendarData[0]['lastDay']; $day++) <?php $hentai = 'day' . $day; ?> <!-- 太線の処理 -->
                                    @if($compshift->emppartid == 1 && $compshift->judge == false)
                                    <td class="loginrow_border">{{ $compshift->$hentai }}</td>
                                    @else
                                    <td class="loginrow">{{ $compshift->$hentai }}</td>
                                    @endif
                                    @endfor
                                    @elseif($rowcolor % 2 == 0)
                                    @for($day= 1; $day <= $calendarData[0]['lastDay']; $day++) <?php $hentai = "day" . $day ?> @if($compshift->judge == false)
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
                                        @for($day= 1; $day <= $calendarData[0]['lastDay']; $day++) <?php $hentai = "day" . $day ?> @if($compshift->judge == false)
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
                                            <td class="loginrow_border">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="loginrow_border">{{ $StaffTimes[$i] }}時間</td>
                                            @else
                                            <td class="loginrow">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="loginrow">{{ $StaffTimes[$i] }}時間</td>
                                            @endif
                                            @elseif($rowcolor % 2 == 0)
                                            @if($compshift->judge == false)
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                            <td class="gusupartrow_border">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="gusupartrow_border">{{ $StaffTimes[$i] }}時間</td>
                                            @else
                                            <td class="gusupartrow">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="gusupartrow">{{ $StaffTimes[$i] }}時間</td>
                                            @endif
                                            @else
                                            <td class="gusuemprow">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="gusuemprow">{{ $StaffTimes[$i] }}時間</td>
                                            @endif
                                            @else
                                            @if($compshift->judge == false)
                                            <td class="kisupartrow">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="kisupartrow">{{ $StaffTimes[$i] }}時間</td>
                                            @else
                                            <td class="kisuemprow">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="kisuemprow">{{ $StaffTimes[$i] }}時間</td>
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
        </div>





        <!-- 来月のシフト -->
        <div class='widget'>
            <div id='{{$nextmonth}}' class="tab-content">
            <form method="post" action="{{ route('new_shiftcreate') }}">
            @csrf
                <table class="month_table">
                    <caption>{{$calendarDataNext[0]["month"]}} 月</caption>
                </table>
                <div class="scrollbox">
                    @if($nextcomshiftjudge == 1)
                    <table class="compshift_table">
                        <thead class="thead">
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            <?php $count = $calendarDataNext[0]['day']; ?>
                            @for ($i = 1; $i <= $calendarDataNext[0]['lastDay']; $i++) <?php
                                                                                        $timestamp = mktime(0, 0, 0, $calendarDataNext[0]['month'], $i, 2023);
                                                                                        $date = date('w', $timestamp);
                                                                                        ?> @if($count==0) <th class="sunday">{{ $i }} 日({{ $week[$count] }})</th>
                                @elseif($count==6)
                                <th class="saturday">{{ $i }} 日({{ $week[$count] }})</th>
                                <?php $count = -1; ?>
                                @elseif($arrayNext[$i]!='-')
                                <th class="holiday">{{ $i }} 日({{ $week[$count] }})</th>
                                @else
                                <th>{{ $i }} 日({{ $week[$count] }})</th>
                                @endif
                                <?php $count++; ?>
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
                                @for ($day = 1; $day <= $calendarDataNext[0]['lastDay']; $day++) <?php $hentai = 'day' . $day; ?> <!-- 太線の処理 -->
                                    @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                    <td class="loginrow_border">{{ $compshiftNext->$hentai }}</td>
                                    @else
                                    <td class="loginrow">{{ $compshiftNext->$hentai }}</td>
                                    @endif
                                    @endfor
                                    @elseif($rowcolor % 2 == 0)
                                    @for($day= 1; $day <= $calendarDataNext[0]['lastDay']; $day++) <?php $hentai = "day" . $day ?> @if($compshiftNext->judge == false)
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
                                        @for($day= 1; $day <= $calendarDataNext[0]['lastDay']; $day++) <?php $hentai = "day" . $day ?> @if($compshiftNext->judge == false)
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
                                            <td class="loginrow_border">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="loginrow_border">{{ $StaffTimesNext[$i] }}時間</td>
                                            @else
                                            <td class="loginrow">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="loginrow">{{ $StaffTimesNext[$i] }}時間</td>
                                            @endif
                                            @elseif($rowcolor % 2 == 0)
                                            @if($compshiftNext->judge == false)
                                            <!-- 太線の処理 -->
                                            @if($compshiftNext->emppartid == 1 && $compshiftNext->judge == false)
                                            <td class="gusupartrow_border">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="gusupartrow_border">{{ $StaffTimesNext[$i] }}時間</td>
                                            @else
                                            <td class="gusupartrow">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="gusupartrow">{{ $StaffTimesNext[$i] }}時間</td>
                                            @endif
                                            @else
                                            <td class="gusuemprow">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="gusuemprow">{{ $StaffTimesNext[$i] }}時間</td>
                                            @endif
                                            @else
                                            @if($compshiftNext->judge == false)
                                            <td class="kisupartrow">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="kisupartrow">{{ $StaffTimesNext[$i] }}時間</td>
                                            @else
                                            <td class="kisuemprow">{{ $StaffworkdaysNext[$i] }}日</td>
                                            <td class="kisuemprow">{{ $StaffTimesNext[$i] }}時間</td>
                                            @endif
                                            @endif
                            </tr>
                            <?php $rowcolor++;
                            $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    @elseif($userId == 0)

                    <!-- シフト未完成時の処理（admin） -->
                    <table class="comshift_not_table">
                        <thead class="thead">
                            <th class="thname"></th>
                            <?php $i = 1;?>
                            @foreach($shiftdivider as $shift_divi)
                                @for($i = 1; $i <= $shift_divicount; $i++)
                                    <?php $time = 'time' . $i;
                                          $time_minus_btn = 'time' . $i. 'minus';
                                          $time_plus_btn = 'time' . $i. 'plus';
                                    ?>
                                    <th class= "shiftdivider">{{$shift_divi -> $time}}
                                    <button type="button" class="th_minus_btn" id="{{$time_minus_btn}}" onclick="scopeminus({{$i}})">-</button>
                                    <button type="button" class="th_plus_btn" id="{{$time_plus_btn}}" onclick="scopeplus({{$i}})">+</button>
                                    </th>
                                @endfor
                            @endforeach
                            <th class= "shiftdivider">合計人数</th>
                        </thead>
                        <tbody>
                        <?php $count = $calendarDataNext[0]['day']; 
                              $gou = $shift_divicount + 1;?>
                            @for ($i = 1; $i <= $calendarDataNext[0]['lastDay']; $i++) <?php
                                                                                        $timestamp = mktime(0, 0, 0, $calendarDataNext[0]['month'], $i, 2023);
                                                                                        $date = date('w', $timestamp);
                                                                                        ?> 
                                @if($count==0) 
                                <tr><td class="sunday_view" id="{{$i}}" name="{{$i}}" onclick="scopeday({{$i}},{{$nextlastday}},{{$shift_divicount}})">{{ $i }} 日({{ $week[$count] }})</td>
                                    @for($time = 1; $time <= $shift_divicount; $time++)
                                        <?php $ninp = $i . '-' . $time; 
                                              $nin_colorid = $i . '*' . $time;
                                              $nin_gou = $i . '-gou';?>
                                        <td id="{{$nin_colorid}}">
                                            <input class="ninp" type="text" name="{{$ninp}}" id="{{$ninp}}" maxLength="2" readonly="readonly"/>
                                        </td>
                                    @endfor
                                    <?php $nin_colorid = $i . '*' . $gou;?>
                                    <td id="{{$nin_colorid}}"><p id="{{$nin_gou}}"></p></td>
                                </tr>
                                @elseif($count==6)
                                <tr><td class="saturday_view" id="{{$i}}" name="{{$i}}" onclick="scopeday({{$i}},{{$nextlastday}},{{$shift_divicount}})">{{ $i }} 日({{ $week[$count] }})</td>
                                    @for($time = 1; $time <= $shift_divicount; $time++)
                                        <?php $ninp = $i . '-' . $time; 
                                              $nin_colorid = $i . '*' . $time;
                                              $nin_gou = $i . '-gou';?>
                                        <td id="{{$nin_colorid}}">
                                            <input class="ninp" type="text" name="{{$ninp}}" id="{{$ninp}}" maxLength="2" readonly="readonly"/>
                                        </td>
                                    @endfor
                                    <?php $nin_colorid = $i . '*' . $gou;?>
                                    <td id="{{$nin_colorid}}"><p id="{{$nin_gou}}"></p></td>
                                </tr>
                                <?php $count = -1; ?>
                                @elseif($arrayNext[$i]!='-')
                                <tr><td class="holiday_view" id="{{$i}}" name="{{$i}}" onclick="scopeday({{$i}},{{$nextlastday}},{{$shift_divicount}})">{{ $i }} 日({{ $week[$count] }})</td>
                                    @for($time = 1; $time <= $shift_divicount; $time++)
                                        <?php $ninp = $i . '-' . $time; 
                                              $nin_colorid = $i . '*' . $time;
                                              $nin_gou = $i . '-gou'; ?>
                                        <td id="{{$nin_colorid}}">
                                            <input class="ninp" type="text" name="{{$ninp}}" id="{{$ninp}}" maxLength="2" readonly="readonly"/>
                                        </td>
                                    @endfor
                                    <?php $nin_colorid = $i . '*' . $gou;?>
                                    <td id="{{$nin_colorid}}"><p id="{{$nin_gou}}"></p></td>
                                </tr>
                                @else
                                <tr><td class="day_view" id="{{$i}}" name="{{$i}}" onclick="scopeday({{$i}},{{$nextlastday}},{{$shift_divicount}})">{{ $i }} 日({{ $week[$count] }})</td>
                                    @for($time = 1; $time <= $shift_divicount; $time++)
                                        <?php $ninp = $i . '-' . $time; 
                                              $nin_colorid = $i . '*' . $time;
                                              $nin_gou = $i . '-gou'; ?>
                                        <td id="{{$nin_colorid}}">
                                            <input class="ninp" type="text" name="{{$ninp}}" id="{{$ninp}}" maxLength="2" readonly="readonly"/>
                                        </td>
                                    @endfor
                                    <?php $nin_colorid = $i . '*' . $gou;?>
                                    <td id="{{$nin_colorid}}"><p id="{{$nin_gou}}"></p></td>
                                </tr>
                                @endif
                                <?php $count++; ?>
                                @endfor

                        </tbody>
                    </table>

                    @else
                    <!-- シフト未完成時の処理（employee,parttimer） -->
                    <p>来月のシフトは未完成です</p>
                    @endif
                </div>
            @if($nextcomshiftjudge == 0 && $userId == 0)
                <button id="createshift_btn" type="submit" name="updateId" class="shiftcreate_btn" onclick="needshift({{$nextlastday}},{{$shift_divicount}})" >シフトを作成</button>
            @endif
            </form>
            </div>
        </div>
        @if ($userId != 0)
            {{ $staffshiftcoverNext }}
        @endif
    </div>
</div>

<script>
    let json_judge  = @json($nextcomshiftjudge);
    let json_loginid  = @json($userId);
    if(json_judge == 0 && json_loginid == 0) {
        let json_lastday = @json($nextlastday);
        let json_timecount = @json($shift_divicount);
        document.getElementById("startdaypull").style.background = "rgba(218, 249, 255)";
        document.getElementById("enddaypull").style.background = "rgba(218, 249, 255)";
        document.getElementById("mom_scopeday").style.visibility ="hidden";
        document.getElementById("createshift_btn").style.visibility ="hidden";
        for(let day = 1; day <= json_lastday; day++){
            for (let time = 1; time <= json_timecount; time++){
                let json_ninid = day + "-" + time;
                document.getElementById(json_ninid).style.visibility ="hidden";
                document.getElementById(json_ninid).disabled =true;
            }
            let ningou = day + "-gou";
            document.getElementById(ningou).textContent = "0人";
        }
    }
</script>
<script type="text/javascript" src="/js/shift_view.js"></script>
<script async src="https://cpwebassets.codepen.io/assets/embed/ei.js"></script>