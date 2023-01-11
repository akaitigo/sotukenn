<link rel="stylesheet" href="/css/scale.css" type="text/css">
<link rel="stylesheet" href="/css/emp_change.css" type="text/css">
<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<script type="text/javascript" src="/js/notice.js"></script>
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
                        <thead>
                            <th class="thname">&nbsp;名前&nbsp;</th>
                            @for($i= 1;$i <= 31; $i++)
                                <?php 
                                    $timestamp = mktime(0,0,0,1,$i,2023);
                                    $date = date('w', $timestamp);
                                ?>
                                @if($i == 9)
                                    <th class="holiday">{{ $i }} 日({{$week[$date]}})</th>
                                @elseif($date == 6)
                                    <th class="saturday">{{ $i }} 日({{$week[$date]}})</th>
                                @elseif($date == 0)
                                    <th class="sunday">{{ $i }} 日({{$week[$date]}})</th>
                                @else
                                    <th>{{ $i }} 日({{$week[$date]}})</th>
                                @endif
                            @endfor
                            <th class="headkisu">労働日数</th>
                            <th class="headkisu">労働時間</th>
                        </thead>
                        <tbody>
                            <?php
                                $empnameid = 0;
                                $partnameid = 0;
                                $rowcolor = 0
                            ?>
                            @foreach($completeshift as $compshift)
                                <tr>
                                    @if($compshift->judge)
                                    <td class="empcolor">{{$empname[$empnameid]}}</td>
                                    <?php $empnameid++ ?>
                                    @else
                                    <td class="partcolor">{{$partname[$partnameid]}}</td>
                                    <?php $partnameid++ ?>
                                    @endif

                                    
                                    @if($compshift->emppartid == $loginid && $compshift->judge == $empjudge)
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai="day".$day?>
                                            <td class="loginrow">{{$compshift->$hentai}}</td>
                                        @endfor
                                    @elseif($rowcolor % 2 == 0)
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai="day".$day?>
                                            <td class="gusurow">{{$compshift->$hentai}}</td>
                                        @endfor
                                    @else
                                        @for($day= 1; $day <= 31; $day++)
                                        <?php $hentai="day".$day?>
                                            <td class="kisurow">{{$compshift->$hentai}}</td>
                                        @endfor
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
