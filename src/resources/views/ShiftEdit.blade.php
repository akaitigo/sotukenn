<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/shiftedit.js"></script>
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
<div id='container'>
            <div class='widget'>
                <div class="tab-content" href="#tab1">
                <table class="month_table">
                    <caption>１ 月</caption>
                </table>
                <div class="scrollbox">
                    <table class="compshift_table">
                        <thead class="thead">
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            @for ($i = 1; $i <= 31; $i++)
                                <?php
                                $timestamp = mktime(0, 0, 0, 1, $i, 2023);
                                $date = date('w', $timestamp);
                                ?>
                                @if ($i == 9)
                                    <th class="holiday">{{ $i }} 日({{ $week[$date] }})</th>
                                @elseif($date == 6)
                                    <th class="saturday">{{ $i }} 日({{ $week[$date] }})</th>
                                @elseif($date == 0)
                                    <th class="sunday">{{ $i }} 日({{ $week[$date] }})</th>
                                @else
                                    <th>{{ $i }} 日({{ $week[$date] }})</th>
                                @endif
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
                            ?>
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
                                <form method="post" action="{{ route('shiftupdate') }}">
                                @csrf
                                    @if ($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        @for ($day = 1; $day <= 31; $day++)
                                            <?php $hentai = 'day' . $day; 
                                                  $javascriptid = $compshift->id . '-' . $day;
                                                  $javascripttd = $compshift->id . '*' . $day; ?>
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                <td class="loginrow_border" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{ $compshift->$hentai }}</td>
                                            @else
                                                <td class="loginrow" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{ $compshift->$hentai }}</td>
                                            @endif

                                        @endfor
                                    @elseif($rowcolor % 2 == 0)
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai = 'day' . $day; 
                                                  $javascriptid = $compshift->id . '-' . $day;
                                                  $javascripttd = $compshift->id . '*' . $day; ?>
                                            @if($compshift->judge == false)
                                                <!-- 太線の処理 -->
                                                @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                    <td class="gusupartrow_border" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{$compshift->$hentai}}</td>
                                                @else
                                                    <td class="gusupartrow" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{$compshift->$hentai}}</td>
                                                @endif
                                            @else
                                                <td class="gusuemprow" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{$compshift->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @else
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai = 'day' . $day; 
                                                  $javascriptid = $compshift->id . '-' . $day;
                                                  $javascripttd = $compshift->id . '*' . $day; ?>
                                            @if($compshift->judge == false)
                                                <td class="kisupartrow" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{$compshift->$hentai}}</td>
                                            @else
                                                <td class="kisuemprow" onclick="test({{$compshift->id}},{{$day}})"><input class="shifttext" type="text" name="shifttext" value="{{ $compshift->$hentai }}" id="{{$javascriptid}}"/><p id="{{$javascripttd}}">{{$compshift->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @endif
                                    </form>


                                    <!-- 労働日数と労働時間 -->
                                    @if ($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        <!-- 太線の処理 -->
                                        @if($compshift->emppartid == 1 && $compshift->judge == false)
                                            <td class="loginrow_work_border">{{ $Staffworkdays[$i] }}</td>
                                            <td class="loginrow_work_border">{{ $StaffTimes[$i] }}</td>
                                        @else
                                            <td class="loginrow_work">{{ $Staffworkdays[$i] }}</td>
                                            <td class="loginrow_work">{{ $StaffTimes[$i] }}</td>
                                        @endif
                                    @elseif($rowcolor % 2 == 0)
                                        @if($compshift->judge == false)
                                            <!-- 太線の処理 -->
                                            @if($compshift->emppartid == 1 && $compshift->judge == false)
                                                <td class="gusupartrow_border_work">{{ $Staffworkdays[$i] }}</td>
                                                <td class="gusupartrow_border_work">{{ $StaffTimes[$i] }}</td>
                                            @else
                                                <td class="gusupartrow_work">{{ $Staffworkdays[$i] }}</td>
                                                <td class="gusupartrow_work">{{ $StaffTimes[$i] }}</td>
                                            @endif
                                        @else
                                            <td class="gusuemprow_work">{{ $Staffworkdays[$i] }}</td>
                                            <td class="gusuemprow_work">{{ $StaffTimes[$i] }}</td>
                                        @endif
                                    @else
                                        @if($compshift->judge == false)
                                            <td class="kisupartrow_work">{{ $Staffworkdays[$i] }}</td>
                                            <td class="kisupartrow_work">{{ $StaffTimes[$i] }}</td>
                                        @else
                                            <td class="kisuemprow_work">{{ $Staffworkdays[$i] }}</td>
                                            <td class="kisuemprow_work">{{ $StaffTimes[$i] }}</td>
                                        @endif
                                    @endif
                                </tr>
                                <?php $rowcolor++;
                                $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
</div>


<script>
    let emppartcountid = @json($empcount);
    for(let id = 1; id <= emppartcountid; id++){
        for (let i = 1; i <= 31; i++){
            let jsid = id + "-" + i;
            let jstd = id + "*" + i;
            document.getElementById(jsid).style.visibility ="hidden";
            document.getElementById(jstd).style.visibility ="visible";
        }
    }
</script>