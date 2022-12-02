<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('header')


<button class="backButton" onclick="history.back()">戻　る</button>

        <a href="{{ route('employeesManagementPassView') }}" class="detailButton">詳細閲覧・変更</a>
        @if(!($employees->isEmpty()))
        <h2 class="employeeH2">正社員一覧</h2>

        <title>従業員管理</title>
        <table class="table" border="2">
            <thead>
                <tr>
                    <th>id</th>
                    <th>email</th>
                    <th>name</th>
                    <th>age</th>
                    <th>weight</th>
                    <th>position</th>
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
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif


        @if(!($parttimers->isEmpty()))
        <h2 class="parttimerH2">アルバイト一覧</h2>

        <table class="table" border="2">
            <thead>
                <tr>
                    <th>id</th>
                    <th>email</th>
                    <th>name</th>
                    <th>age</th>
                    <th>weight</th>
                    <th>position</th>
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
        <br/>
        <br/>
        <br/>
        <br/>
        @endif















