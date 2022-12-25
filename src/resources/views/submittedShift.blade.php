<!DOCTYPE html>
<html lang="ja">
    <head>
    <link rel="stylesheet" href="/css/submittedShift.css" type="text/css">
    </head>
    <body>
    @include('header')
        <div>
        <h2>現在のシフト提出状況</h2>
        @if(!($employees->isEmpty()))
        <div class="alltable">
            <table class="tablesubcomp">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>提出状況</th>
                        <th>view</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $emp)
                        <?php $i = 0; ?>
                            <tr>
                                <td class="subcompempname">{{$emp->id}}</td>
                                <td class="subcompempname">{{$emp->name}}</td>
                                @foreach($submitcompempid as $subcompempid)
                                    @if($subcompempid == $emp->id)
                                    <td style="background-color:#55f;">済</td>
                                    <td class="subcompempname_btn"><button style="background-color:#55f;">確認</button></td>
                                    <?php $i = 1; ?>
                                    @endif
                                @endforeach
                                @if($i == 0)
                                    <td style="background-color:#f55;">未</td>
                                    <td class="subcompempname_btn"><button style="background-color:#f55;">通知</button></td>
                                @endif
                            </tr>
                    @endforeach
                </tbody>
            </table><br>

            <table class="tablenotsub">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>提出状況</th>
                        <th>view</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parttimers as $part)
                        <?php $i = 0; ?>
                            <tr>
                                <td class="subcomppartname">{{$part->id}}</td>
                                <td class="subcomppartname">{{$part->name}}</td>
                                @foreach($submitcomppartid as $subcomppartid)
                                    @if($subcomppartid == $part->id)
                                    <td style="background-color:#55f;">済</td>
                                    <td class="subcomppartname_btn"><button style="background-color:#55f;">確認</button></td>
                                    <?php $i = 1; ?>
                                    @endif
                                @endforeach
                                @if($i == 0)
                                    <td style="background-color:#f55;">未</td>
                                    <td class="subcomppartname_btn"><button style="background-color:#f55;">通知</button></td>
                                @endif
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        </div>
            <a href="{{ route('shiftView') }}" >緊急アルゴリズムテスト</a>