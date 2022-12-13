<link rel="stylesheet" href="/css/employeeManagement.css" type="text/css">
@include('header')

<button class="backButton" onclick="history.back()">戻　る</button>
<a href="{{ route('employeesManagementPassNotView') }}" class="passViewButton">メール非表示</a>

<title>従業員管理</title>

@if(!($employees->isEmpty()))

<h2>正社員一覧</h2>

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
            <th>notice</th>
            <th>change</th>

        </tr>
    </thead>

    <tbody>
        @foreach ($employees as $emp)

        <tr>
            <td>{{ $emp->id}}</td>
            <td>{{$emp->email}}</td>
            <td>{{ $emp->name }}</td>
            <td>{{$emp->age}}</td>
            <td>{{ $emp->weight}}</td>
            <td> @foreach($emp-> Jobs as $job)

                {{$job->name}}

                @endforeach
            </td>

            @if(!(is_null($emp->lineUserId)))
            <form method="get" action="{{route('messagessent')}}">
                @csrf
                <td><button type="submit" name="noticeId" value="{{$emp->id}}" class="noticeButton">通知</button></td>
            </form>
            @endif
            @if(is_null($emp->lineUserId))
            <td><p>未登録</p></td>
            @endif


            <form method="get" action="{{route('employeesManagementChange')}}">
                @csrf
                <td><button type="submit" name="empChange" value="{{$emp->id}}">変　更</button></td>
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
            <th>age</th>
            <th>weight</th>
            <th>position</th>
            <th>notice</th>
            <th>change</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($parttimers as $part)

        <tr>
            <td>{{ $part->id}}</td>
            <td>{{$part->email}}</td>
            <td>{{ $part->name }}</td>
            <td>{{$part->age}}</td>
            <td>{{ $part->weight}}</td>

            <td> @foreach($part-> Jobs as $job)

                {{$job->name}}

                @endforeach
            </td>

                @if(!(is_null($part->lineUserId)))
            <form method="get" action="{{route('partMessagessent')}}">
                @csrf
                <td><button type="submit" name="noticeId" value="{{$part->id}}" class="noticeButton">通知</button></td>
            </form>
            @endif
            @if(is_null($part->lineUserId))
            <td><p>未登録</p></td>
            @endif
            <form method="get" action="{{route('partManagementChange')}}">
                @csrf
                <td class="underTd"><button type="submit" name="partChange" value="{{$part->id}}">変　更</button></td>
            </form>
        </tr>
        @endforeach
    </tbody>
</table>
<br/>
<br/>
<br/>
<br/>

@endif


