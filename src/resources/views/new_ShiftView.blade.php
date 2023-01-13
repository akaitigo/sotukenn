<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/notice.js"></script>
<title>シフト閲覧</title>
@include('new_header')
<div id="scale">
    <div id='container'>
        <div class="colorbox_flex">
            <div class="colorbox empcolor">
            </div>
            <div class="colorbox_text">
                従業員
            </div>
            <div class="colorbox partcolor" id="makeImg">
            </div>
            <div class="colorbox_text">
                アルバイト
            </div>
        </div>
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
                            ?>
                            @foreach ($completeshift as $compshift)
                                <tr>
                                @if($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                    @if($compshift->judge)
                                    <td class="loginrow">{{$empname[$empnameid]}}</td>
                                    <?php $empnameid++ ?>
                                    @else
                                    <td class="loginrow">{{$partname[$partnameid]}}</td>
                                    <?php $partnameid++ ?>
                                    @endif
                                @elseif($rowcolor % 2 == 0)
                                    @if($compshift->judge)
                                    <td class="gusuemprow">{{$empname[$empnameid]}}</td>
                                    <?php $empnameid++ ?>
                                    @else
                                    <td class="gusupartrow">{{$partname[$partnameid]}}</td>
                                    <?php $partnameid++ ?>
                                    @endif
                                @else
                                    @if($compshift->judge)
                                    <td class="kisuemprow">{{$empname[$empnameid]}}</td>
                                    <?php $empnameid++ ?>
                                    @else
                                    <td class="kisupartrow">{{$partname[$partnameid]}}</td>
                                    <?php $partnameid++ ?>
                                    @endif
                                @endif


                                    @if ($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        @for ($day = 1; $day <= 31; $day++)
                                            <?php $hentai = 'day' . $day; ?>
                                            <td class="loginrow">{{ $compshift->$hentai }}</td>
                                        @endfor
                                    @elseif($rowcolor % 2 == 0)
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai="day".$day?>
                                            @if($compshift->judge == false)
                                                <td class="gusupartrow">{{$compshift->$hentai}}</td>
                                            @else
                                                <td class="gusuemprow">{{$compshift->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @else
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai="day".$day?>
                                            @if($compshift->judge == false)
                                                <td class="kisupartrow">{{$compshift->$hentai}}</td>
                                            @else
                                                <td class="kisuemprow">{{$compshift->$hentai}}</td>
                                            @endif
                                        @endfor
                                    @endif

                                    @if ($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        <td class="loginrow">{{ $Staffworkdays[$i] }}</td>
                                        <td class="loginrow">{{ $StaffTimes[$i] }}</td>
                                    @elseif($rowcolor % 2 == 0)
                                        <td class="gusurow">{{ $Staffworkdays[$i] }}</td>
                                        <td class="gusurow">{{ $StaffTimes[$i] }}</td>
                                    @else
                                        <td class="kisurow">{{ $Staffworkdays[$i] }}</td>
                                        <td class="kisurow">{{ $StaffTimes[$i] }}</td>
                                    @endif
                                </tr>
                                <?php $rowcolor++;
                                $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($loginid != 0)
                    {{ $staffshiftcover }}
                @endif
            </div>
        </div>
    </div>
</div>
