<link rel="stylesheet" href="/css/submittedShift.css" type="text/css">
    @include('header')
        <div>
        <h2>現在のシフト提出状況</h2>
        @if(!($employees->isEmpty()))
        <div class="alltable">
            <table class="tablesubcomp">
                <thead>
                    <tr>
                        <th colspan="2">提出済み</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submitcompempname as $subcompempname)
                        <tr>
                            <td class="subcompempname">{{$subcompempname}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    @foreach ($submitcomppartname as $subcomppartname)
                        <tr>
                            <td class="subcomppartname">{{$subcomppartname}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table><br>

            <table class="tablenotsub">
                <thead>
                    <tr>
                        <th colspan="2">未提出</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notsubmitempname as $notsubempname)
                    <tr>
                        <td class="notsubempname">{{$notsubempname}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                    @foreach ($notsubmitpartname as $notsubpartname)
                    <tr>
                        <td class="notsubpartname">{{$notsubpartname}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        </div>
            <a href="{{ route('submittedShiftDetail') }}" >提出済み従業員それぞれのシフト確認ボタン</a>
