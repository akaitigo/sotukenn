<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('header')


<a href="{{ route('employeesManagementPassNotView') }}">パスワード非表示</a>



@if(!($employees->isEmpty()))

<h2>正社員一覧</h2>

<title>従業員管理</title>
<table class="table" border="2">
    <thead>
        <tr>
            <th>id</th>
            <th>email</th>
            <th>name</th>
            <th>weight</th>
            <th>position</th>
            <th>pass</th>
            <th>change</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($employees as $emp)

        <tr>
            <td>{{ $emp->id}}</td>
            <td>{{$emp->email}}</td>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->weight}}</td>

            <td> @foreach($emp-> Jobs as $job)

                {{$job->name}}

                @endforeach
            </td>
            <td>{{ $emp->password }}</td>
            @csrf
            <form method="get" action="{{route('employeesManagementChange')}}">
                <td><button type="submit" name="empChange" value="{{$emp->id}}">変更</button></td>
            </form>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if(!($parttimers->isEmpty()))


<h2>アルバイト一覧</h2>

<table class="table" border="2">
    <thead>
        <tr>
            <th>id</th>
            <th>email</th>
            <th>name</th>
            <th>weight</th>
            <th>position</th>
            <th>pass</th>
            <th>change</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($parttimers as $part)

        <tr>
            <td>{{ $part->id}}</td>
            <td>{{$part->email}}</td>
            <td>{{ $part->name }}</td>
            <td>{{ $part->weight}}</td>

            <td> @foreach($part-> Jobs as $job)

                {{$job->name}}

                @endforeach
            </td>
            <td>{{ $part->password }}</td>
            @csrf
            <form method="get" action="{{route('partManagementChange')}}">
                <td><button type="submit" name="partChange" value="{{$part->id}}">変更</button></td>
            </form>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
