<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/shiftedit.js"></script>
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
            @if ($loginid != 0)
            <div class="colorbox loginrow_name" id="makeImg">
            </div>
            <div class="colorbox_text">
                ログイン中
            </div>
            @endif
        </div>
            <div class='widget'>
                <div class="tab-content" href="#tab1">
                <table class="month_table">
                    <caption>{{$thisMonth}} 月</caption>
                </table>
                <div class="scrollbox">
                    <table class="compshift_edit_table">
                    <thead class="thead">
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            <?php $count = $calendarData[0]['day']; ?>
                            @for ($i = 1; $i <= $calendarData[0]['lastDay']; $i++) <?php
                                                                                    $timestamp = mktime(0, 0, 0, $calendarData[0]['month'], $i, 2023);
                                                                                    $date = date('w', $timestamp);
                                                                                    ?> @if($count==0) <th class="sunday">{{ $i }} 日({{ $week[$count] }})</th>
                                @elseif($count==6)
                                <th class="saturday">{{ $i }} 日({{ $week[$count] }})</th>
                                <?php $count = -1; ?>
                                @elseif($array[$i]!='-')
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
                            $empcount = $emppartcount;
                            $lastday = $calendarData[0]['lastDay'];
                            $json_emppartname = json_encode($emppartname);
                            ?>

                            <form method="post" onsubmit="return update({{$empcount}},{{$json_emppartname}},{{$lastday}})" action="{{ route('shiftupdate') }}">
                            @csrf

                            @foreach ($completeshift as $compshift)
                                <tr>
                                <!-- 名前の処理 -->
                                @if($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
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
                                
                                    @if ($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        @for ($day = 1; $day <= $calendarData[0]['lastDay']; $day++)
                                            <?php $hentai = 'day' . $day; 
                                                  $javascriptid = $compshift->id . '-' . $day;
                                                  $javascripttd = $compshift->id . '*' . $day; ?>
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                <td class="loginrow_edit_border" onclick="test({{$compshift->id}},{{$day}})">
                                                    <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="5"/>
                                                    <p id="{{$javascripttd}}">{{ $compshift->$hentai }}</P>
                                                </td>
                                            @else
                                                <td class="loginrow_edit" onclick="test({{$compshift->id}},{{$day}})">
                                                    <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="5"/>
                                                    <p id="{{$javascripttd}}">{{ $compshift->$hentai }}</P>
                                                </td>
                                            @endif

                                        @endfor
                                    @elseif($rowcolor % 2 == 0)
                                        @for($day= 1; $day <= $calendarData[0]['lastDay']; $day++)
                                        <?php $hentai = 'day' . $day; 
                                                  $javascriptid = $compshift->id . '-' . $day;
                                                  $javascripttd = $compshift->id . '*' . $day;
                                                  (string)$returnshift = $compshift->$hentai ;
                                                  $workstarttimepull = $compshift->id . '-' . $day .'start';
                                                  $workendtimepull = $compshift->id . '-' . $day .'end';
                                                  $haihunpull = $compshift->id . '-' . $day .'haihun';
                                                  $chengebtn = $compshift->id . '-' . $day .'chenge';
                                                  $returnbtn = $compshift->id . '-' . $day .'return';
                                                  $batsubtn = $compshift->id . '-' . $day .'batsu'; ?>
                                            @if($compshift->judge == false)
                                                <!-- 太線の処理 -->
                                                @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                    <td class="gusupartrow_edit_border">
                                                        <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="9" readonly="readonly"/>
                                                        <p class="shiftp" id="{{$javascripttd}}">{{$compshift->$hentai}}</P>
                                                        <input class="starttimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workstarttimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                                        <p class="hihunp" id="{{$haihunpull}}">-</p>
                                                        <input class="endtimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workendtimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                                        <button class="chengebtn" type="button" id="{{$chengebtn}}" onclick="chenge({{$compshift->id}},{{$day}})">変更</button>
                                                        <button class="returnbtn" type="button" id="{{$returnbtn}}" onclick="shiftreturn({{$compshift->id}},{{$day}},'{{$returnshift}}')">元に戻す</button>
                                                        <button class="batsubtn" type="button"  id="{{$batsubtn}}" onclick="addbatsu({{$compshift->id}},{{$day}})">欠勤</button>
                                                    </td>
                                                @else
                                                    <td class="gusupartrow_edit">
                                                        <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="9" readonly="readonly"/>
                                                        <p class="shiftp" id="{{$javascripttd}}">{{$compshift->$hentai}}</P>
                                                        <input class="starttimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workstarttimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                                        <p class="hihunp" id="{{$haihunpull}}">-</p>
                                                        <input class="endtimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workendtimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                                        <button class="chengebtn" type="button" id="{{$chengebtn}}" onclick="chenge({{$compshift->id}},{{$day}})">変更</button>
                                                        <button class="returnbtn" type="button" id="{{$returnbtn}}" onclick="shiftreturn({{$compshift->id}},{{$day}},'{{$returnshift}}')">元に戻す</button>
                                                        <button class="batsubtn" type="button" id="{{$batsubtn}}" onclick="addbatsu({{$compshift->id}},{{$day}})">欠勤</button>
                                                    </td>
                                                @endif
                                            @else
                                                    <td class="gusuemprow_edit">
                                                        <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="9" readonly="readonly"/>
                                                        <p class="shiftp" id="{{$javascripttd}}">{{$compshift->$hentai}}</P>
                                                        <input class="starttimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workstarttimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                                        <p class="hihunp" id="{{$haihunpull}}">-</p>
                                                        <input class="endtimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workendtimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                                        <button class="chengebtn" type="button" id="{{$chengebtn}}" onclick="chenge({{$compshift->id}},{{$day}})">変更</button>
                                                        <button class="returnbtn" type="button" id="{{$returnbtn}}" onclick="shiftreturn({{$compshift->id}},{{$day}},'{{$returnshift}}')">元に戻す</button>
                                                        <button class="batsubtn" type="button" id="{{$batsubtn}}" onclick="addbatsu({{$compshift->id}},{{$day}})">欠勤</button>
                                                    </td>
                                            @endif
                                        @endfor
                                    @else
                                        @for($day= 1; $day <= $calendarData[0]['lastDay']; $day++)
                                        <?php $hentai = 'day' . $day; 
                                                  $javascriptid = $compshift->id . '-' . $day;
                                                  $javascripttd = $compshift->id . '*' . $day;
                                                  (string)$returnshift = $compshift->$hentai ;
                                                  $workstarttimepull = $compshift->id . '-' . $day .'start';
                                                  $workendtimepull = $compshift->id . '-' . $day .'end';
                                                  $haihunpull = $compshift->id . '-' . $day .'haihun';
                                                  $chengebtn = $compshift->id . '-' . $day .'chenge';
                                                  $returnbtn = $compshift->id . '-' . $day .'return';
                                                  $batsubtn = $compshift->id . '-' . $day .'batsu'; ?>
                                            @if($compshift->judge == false)
                                                <td class="kisupartrow_edit">
                                                    <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="9" readonly="readonly"/>
                                                    <p class="shiftp" id="{{$javascripttd}}">{{$compshift->$hentai}}</P>
                                                    <input class="starttimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workstarttimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                                    <p class="hihunp" id="{{$haihunpull}}">-</p>
                                                    <input class="endtimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workendtimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                                    <button class="chengebtn" type="button" id="{{$chengebtn}}" onclick="chenge({{$compshift->id}},{{$day}})">変更</button>
                                                    <button class="returnbtn" type="button" id="{{$returnbtn}}" onclick="shiftreturn({{$compshift->id}},{{$day}},'{{$returnshift}}')">元に戻す</button>
                                                    <button class="batsubtn" type="button" id="{{$batsubtn}}" onclick="addbatsu({{$compshift->id}},{{$day}})">欠勤</button>
                                                </td>
                                            @else
                                                <td class="kisuemprow_edit">
                                                    <input class="shifttext" type="text" name="{{$javascriptid}}" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}" maxLength="9" readonly="readonly"/>
                                                    <p class="shiftp" id="{{$javascripttd}}">{{$compshift->$hentai}}</P>
                                                    <input class="starttimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workstarttimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="出勤"/>
                                                    <p class="hihunp" id="{{$haihunpull}}">-</p>
                                                    <input class="endtimepull" type="number" oninput="addshifttime({{$compshift->id}},{{$day}})" id="{{$workendtimepull}}" min="{{$workstarttime}}" max="{{$workendtime}}" step="0.5" placeholder="退勤"/>
                                                    <button class="chengebtn" type="button" id="{{$chengebtn}}" onclick="chenge({{$compshift->id}},{{$day}})">変更</button>
                                                    <button class="returnbtn" type="button" id="{{$returnbtn}}" onclick="shiftreturn({{$compshift->id}},{{$day}},'{{$returnshift}}')">元に戻す</button>
                                                    <button class="batsubtn" type="button" id="{{$batsubtn}}" onclick="addbatsu({{$compshift->id}},{{$day}})">欠勤</button>
                                                </td>
                                            @endif
                                        @endfor
                                    @endif
                


                                    <!-- 労働日数と労働時間 -->
                                    @if ($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        <!-- 太線の処理 -->
                                        @if($compshift->emppartid == 1 && $compshift->judge == false)
                                            <td class="loginrow_work_border">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="loginrow_work_border">{{ $StaffTimes[$i] }}時間</td>
                                        @else
                                            <td class="loginrow_work">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="loginrow_work">{{ $StaffTimes[$i] }}時間</td>
                                        @endif
                                    @elseif($rowcolor % 2 == 0)
                                        @if($compshift->judge == false)
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                <td class="gusupartrow_work_border">{{ $Staffworkdays[$i] }}日</td>
                                                <td class="gusupartrow_work_border">{{ $StaffTimes[$i] }}時間</td>
                                            @else
                                                <td class="gusupartrow_work">{{ $Staffworkdays[$i] }}日</td>
                                                <td class="gusupartrow_work">{{ $StaffTimes[$i] }}時間</td>
                                            @endif
                                        @else
                                            <td class="gusuemprow_work">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="gusuemprow_work">{{ $StaffTimes[$i] }}時間</td>
                                        @endif
                                    @else
                                        @if($compshift->judge == false)
                                            <td class="kisupartrow_work">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="kisupartrow_work">{{ $StaffTimes[$i] }}時間</td>
                                        @else
                                            <td class="kisuemprow_work">{{ $Staffworkdays[$i] }}日</td>
                                            <td class="kisuemprow_work">{{ $StaffTimes[$i] }}時間</td>
                                        @endif
                                    @endif
                                </tr>
                                <?php $rowcolor++;
                                $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <button type="submit" name="updateId" class="updateButton">更新</button>
                    </form>
                </div>
            </div>
        </div>
</div>


<script>
    let emppartcountid = @json($empcount);
    let json_lastday = @json($lastday);
    let judge = 0;
    for(let id = 1; id <= emppartcountid; id++){
        for (let i = 1; i <= json_lastday; i++){
            let jsid = id + "-" + i;
            let jstd = id + "*" + i;
            let starttimepull = id + "-" + i + "start";
            let endtimepull = id + "-" + i + "end";
            let haihunpull = id + "-" + i + "haihun";
            let batsubtn = id + "-" + i + "batsu";
            let returnbtn = id + "-" + i + "return";
            document.getElementById(returnbtn).style.visibility ="hidden";
            document.getElementById(batsubtn).style.visibility ="hidden";
            document.getElementById(jsid).style.visibility ="hidden";
            document.getElementById(jstd).style.visibility ="visible";
            document.getElementById(starttimepull).style.visibility ="hidden";
            document.getElementById(endtimepull).style.visibility ="hidden";
            document.getElementById(haihunpull).style.visibility ="hidden";
        }
    }

</script>