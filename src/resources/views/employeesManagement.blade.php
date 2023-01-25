<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
<link rel="stylesheet" href="/css/slide.css" type="text/css">
@include('new_header')

<body>
    <div id=slide>
        <button class="backButton" onclick="history.back()">戻　る</button>

        <a href="{{ route('employeesManagementPassView') }}" class="detailButton">詳細閲覧・変更・個別通知</a>
        @if(!($employees->isEmpty()))
        <h2 class="employeeH2">正社員一覧</h2>

        <title>従業員管理</title>
        <table class="table" border="4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>名前</th>
                    <th>メール</th>
                    <th>年齢</th>
                    <th>重み</th>
                    <th>ポジション</th>
                    <th>最大労働時間</th>
                    <th>最低労働時間</th>
                    <th>パスワード</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($employees as $emp)
                <tr>
                    <td>{{ $emp->id}}</td>
                    <td>****@****</td>
                    <td>{{ $emp->name }}</td>
                    <td>**</td>
                    <td>{{ $emp->weight}}</td>

                    <td> @foreach($emp-> Jobs as $job)
                        {{$job->name}}

                        @endforeach
                    </td>


                    <td>@if({{$emp->monthmaxworktime}}==-1)
                        設定なし
                        @elseif
                        {{$emp->monthmaxworktime}}
                        @endif
                    </td>
                    <td>@if({{$emp->monthminworktime}}==-1)
                        設定なし
                        @elseif
                        {{$emp->monthminworktime}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif


        @if(!($parttimers->isEmpty()))
        <h2 class="parttimerH2">アルバイト一覧</h2>

        <table class="table" border="4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>メール</th>
                    <th>名前</th>
                    <th>年齢</th>
                    <th>期待値</th>
                    <th>ポジション</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parttimers as $parttimer)
                <tr>
                    <td>{{ $parttimer->id}}</td>
                    <td>****@****</td>
                    <td>{{ $parttimer->name }}</td>
                    <td>**</td>
                    <td>{{ $parttimer->weight}}</td>

                    <td class="underTd"> @foreach($parttimer-> Jobs as $job)

                        {{$job->name}}

                        @endforeach
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <br />
        <br />
        <br />
        <br />
        @endif
    </div>
</body>